<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/BoardModel.php';
require_once __DIR__ . '/../helpers/current_user_id.php';

class BoardController extends Controller {
	protected $boardModel;

	public function __construct($pdo) {
		parent::__construct($pdo);
		$this->boardModel = new BoardModel($pdo);
	}

	public function showBoards($error = null) {
		$this->requireLogin();

		$boards = $this->boardModel->getBoardsByUser( currentUserId() );

		$this->render('boards', ['error' => $error, 'boards' => $boards]);
	}

	public function showEditBoard($board = [], $error = null) {
		$this->requireLogin();

		$this->render('edit_board', ['error' => $error, 'board' => $board]);
	}

	// create new board
	public function storeBoard() {
		$this->requireLogin();

		$boardName = trim($_POST['name'] ?? '');
		$user_id = currentUserId();

		if ( $boardName === '' ) {
			$this->showBoards('Board name fields is required.');
			exit;
		}

		$board = $this->boardModel->createBoard($user_id, $boardName);

		if ( $board ) {
			$_SESSION['board-crud-success'] = 'Board successfully created.';
			header('Location: index.php?action=showBoards');
			exit;
		} else {
			$this->showBoards('Board name already exists.');
		}
	}

	// edit board
	public function editBoard() {
		$this->requireLogin();

		$id = (int) $_GET['id'] ?? 0;
		$error = $_GET['error'] ?? null;
		$user_id = currentUserId();

		if ( !$id ) {
			$this->showBoards('ID Board missing.');
			exit;
		}

		$board = $this->boardModel->getBoardById($id, $user_id);

		if ( !$board ) {
			$this->showBoards('No board found.');
			exit;
		}

		$this->showEditBoard($board, $error);
	}

	// update board
	public function updateBoard() {
		$this->requireLogin();

		$boardId = (int) $_POST['id'] ?? 0;
		$boardName = trim($_POST['name'] ?? '');
		$user_id = currentUserId();

		if ( !$boardId ) {
			$this->showBoards('ID board missing.');
			exit;
		}
		if ( $boardName === '' ) {
			header("Location: index.php?action=editBoard&id=$boardId&error=Board%20name%20fields%20is%20required.");
			exit;
		}

		$board = $this->boardModel->updateBoard($boardId, $boardName, $user_id);

		if ( $board ) {
			$_SESSION['board-crud-success'] = 'Board successfully updated.';
			header('Location: index.php?action=showBoards');
			exit;
		} else {
			header("Location: index.php?action=editBoard&id=$boardId&error=Board%20name%20or%20slug%20already%20exists.");
		}
	}

	// delete board
	public function deleteBoard() {
		$this->requireLogin();

		$id = (int) $_POST['id'] ?? 0;
		$user_id = currentUserId();

		if ( !$id ) {
			$this->showBoards('ID board missing.');
			exit;
		}

		$deleted = $this->boardModel->deleteBoard($id, $user_id);

		if ( $deleted ) {
			$_SESSION['board-crud-success'] = 'Board successfully deleted.';
			header('Location: index.php?action=showBoards');
			exit;
		} else {
			$this->showBoards('Board error deleting.');
		}
	}
}