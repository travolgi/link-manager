<?php
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/BoardController.php';
require_once __DIR__ . '/../app/controllers/LinkController.php';

$authController = new AuthController($pdo);
$dashboardController = new DashboardController($pdo);
$boardController = new BoardController($pdo);
$linkController = new LinkController($pdo);

$action = $_GET['action'] ?? '';

// router
switch ($action) {
	case 'showLogin':
		if ( !isset($_SESSION['user_id']) ) {
			$authController->showLogin();
		} else {
			header('Location: index.php?action=showDashboard');
		}
		break;

	case 'login':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$authController->login();
		} else {
			header('Location: index.php?action=showLogin');
		}
		break;

	case 'showRegister':
		if ( !isset($_SESSION['user_id']) ) {
			$authController->showRegister();
		} else {
			header('Location: index.php?action=showDashboard');
		}
		break;

	case 'register':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$authController->register();
		} else {
			header('Location: index.php?action=showRegister');
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
		} else {
			header('Location: index.php?action=showBoards');
		}
		break;

	case 'editBoard':
		$boardController->editBoard();
		break;

	case 'updateBoard':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$boardController->updateBoard();
		} else {
			header('Location: index.php?action=editBoard');
		}
		break;

	case 'deleteBoard':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$boardController->deleteBoard();
		} else {
			header('Location: index.php?action=showBoards');
		}
		break;

	case 'showLinks':
		$linkController->showLinks();
		break;

	case 'storeLink':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
			$linkController->storeLink();
		} else {
			header('Location: index.php?action=showLinks');
		}
		break;

	case 'editLink':
		$linkController->editLink();
		break;

	case 'updateLink':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$linkController->updateLink();
		} else {
			header('Location: index.php?action=editLink');
		}
		break;

	case 'deleteLink':
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$linkController->deleteLink();
		} else {
			header('Location: index.php?action=showLinks');
		}
		break;

	default:
		$dashboardController->showDashboard();
		break;
}