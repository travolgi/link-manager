<?php
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/BoardController.php';
require_once __DIR__ . '/../app/controllers/LinkController.php';

// init
$controllers = [
	'auth' => new AuthController($pdo),
	'dashboard' => new DashboardController($pdo),
	'board' => new BoardController($pdo),
	'link' => new LinkController($pdo),
];

// routing
$routes = [
	'showLogin'      => ['auth', 'showLogin', false, 'showDashboard', true],
	'login'          => ['auth', 'login', true, 'showLogin'],
	'showRegister'   => ['auth', 'showRegister', false, 'showDashboard', true],
	'register'       => ['auth', 'register', true, 'showRegister'],
	'logout'         => ['auth', 'logout', false],

	'showProfile'    => ['auth', 'showProfile', false],
	'changePassword' => ['auth', 'showChangePassword', false],
	'editProfile'    => ['auth', 'showEditProfile', false],
	'updateProfile'  => ['auth', 'updateProfile', true, 'showProfile'],
	'updatePassword' => ['auth', 'updatePassword', true, 'showProfile'],
	'deleteProfile'  => ['auth', 'deleteProfile', true],

	'dashboard'      => ['dashboard', 'showDashboard', false],

	'showBoards'     => ['board', 'showBoards', false],
	'storeBoard'     => ['board', 'storeBoard', true, 'showBoards'],
	'editBoard'      => ['board', 'editBoard', false],
	'updateBoard'    => ['board', 'updateBoard', true, 'editBoard'],
	'deleteBoard'    => ['board', 'deleteBoard', true, 'showBoards'],

	'showLinks'      => ['link', 'showLinks', false],
	'storeLink'      => ['link', 'storeLink', true, 'showLinks'],
	'editLink'       => ['link', 'editLink', false],
	'updateLink'     => ['link', 'updateLink', true, 'editLink'],
	'deleteLink'     => ['link', 'deleteLink', true, 'showLinks'],
];

$action = $_GET['action'] ?? '';

if ( !isset($routes[$action]) ) {
	$action = 'dashboard';
}

list( $controllerKey, $method, $requirePost, $redirect, $guestOnly ) = array_pad($routes[$action], 5, null);
$controller = $controllers[$controllerKey] ?? null;

// check user
if ( !empty( $guestOnly ) && isset( $_SESSION['user_id'] ) ) {
	header('Location: index.php?action=dashboard');
	exit;
}

// check POST
if ( !empty( $requirePost ) && $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
	header("Location: index.php?action=$redirect");
	exit;
}

$controller->$method();