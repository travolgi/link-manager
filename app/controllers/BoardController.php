<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/BoardModel.php';
require_once __DIR__ . '/../models/LinkModel.php';

class BoardController extends Controller {
	protected $boardModel;
	protected $linkModel;

	public function __construct($pdo) {
		parent::__construct($pdo);
		$this->boardModel = new BoardModel($pdo);
		$this->linkModel = new LinkModel($pdo);
	}

	public function showBoards($error = null) {
		$this->requireLogin();

		$boards = $this->boardModel->getBoardsByUser( $this->currentUserId );
		$boardsLinks = [];
		foreach ($boards as $board) {
			$boardsLinks[ $board['id'] ] = $this->linkModel->getLinksByBoard( $this->currentUserId, $board['id'] );
		}
		$boardsLinks[ 'null' ] = $this->linkModel->getLinksByBoard( $this->currentUserId );

		$this->render('boards', ['error' => $error, 'boards' => $boards, 'boardsLinks' => $boardsLinks]);
	}

	public function showEditBoard($board = [], $error = null) {
		$this->requireLogin();

		$this->render('edit_board', ['error' => $error, 'board' => $board]);
	}

	// create new board
	public function storeBoard() {
		$this->requireLogin();
		$this->checkCsrfToken();

		$boardName = trim($_POST['name'] ?? '');

		if ( $boardName === '' ) {
			$this->showBoards('Board name fields is required.');
			exit;
		}

		$board = $this->boardModel->createBoard( $this->currentUserId, $boardName );

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

		if ( !$id ) {
			$this->showBoards('ID Board missing.');
			exit;
		}

		$board = $this->boardModel->getBoardById( $id, $this->currentUserId );

		if ( !$board ) {
			$this->showBoards('No board found.');
			exit;
		}

		$this->showEditBoard($board, $error);
	}

	// update board
	public function updateBoard() {
		$this->requireLogin();
		$this->checkCsrfToken();

		$boardId = (int) $_POST['id'] ?? 0;
		$boardName = trim($_POST['name'] ?? '');

		if ( !$boardId ) {
			$this->showBoards('ID board missing.');
			exit;
		}
		$errors = [];
		if ( $boardName === '' ) {
			$errors = 'Board name fields is required.';
		}
		if ( !empty($errors) ) {
			$_SESSION['errors'] = $errors;
			$_SESSION['old'] = $_POST;
 
			header("Location: index.php?action=editBoard&id=$boardId");
			exit;
	  	}

		$board = $this->boardModel->updateBoard( $boardId, $boardName, $this->currentUserId );

		if ( $board ) {
			$_SESSION['board-crud-success'] = 'Board successfully updated.';
			header('Location: index.php?action=showBoards');
			exit;
		} else {
			$_SESSION['errors'] = 'Board name or slug already exists.';
			$_SESSION['old'] = $_POST;
 
			header("Location: index.php?action=editBoard&id=$boardId");
			exit;
		}
	}

	// delete board
	public function deleteBoard() {
		$this->requireLogin();
		$this->checkCsrfToken();

		$id = (int) $_POST['id'] ?? 0;

		if ( !$id ) {
			$this->showBoards('ID board missing.');
			exit;
		}

		$deleted = $this->boardModel->deleteBoard( $id, $this->currentUserId );

		if ( $deleted ) {
			$_SESSION['board-crud-success'] = 'Board successfully deleted.';
			header('Location: index.php?action=showBoards');
			exit;
		} else {
			$this->showBoards('Board error deleting.');
		}
	}
}