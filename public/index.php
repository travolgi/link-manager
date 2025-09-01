<?php
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/BoardController.php';

$authController = new AuthController($pdo);
$dashboardController = new DashboardController($pdo);
$boardController = new BoardController($pdo);

$action = $_GET['action'] ?? '';

// router
switch ($action) {
	case 'showLogin':
		$authController->showLogin();
		break;

	case 'login':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$authController->login();
		}
		break;

	case 'showRegister':
		$authController->showRegister();
		break;

	case 'register':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$authController->register();
		}
		break;

	case 'logout':
		$authController->logout();
		break;

	case 'dashboard':
		$dashboardController->showDashboard();
		break;

	case 'showBoards':
		$boardController->showBoards();
		break;

	case 'storeBoard':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$boardController->storeBoard();
		}
		break;

	case 'editBoard':
		$boardController->editBoard();
		break;

	case 'updateBoard':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$boardController->updateBoard();
		}
		break;

	case 'deleteBoard':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$boardController->deleteBoard();
		}
		break;

	default:
		$dashboardController->showDashboard();
		break;
}