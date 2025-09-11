<?php 
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/LinkModel.php';
require_once __DIR__ . '/../models/BoardModel.php';

class LinkController extends Controller {
	protected $linkModel;
	private $boardModel;


	public function __construct($pdo) {
		parent::__construct($pdo);
		$this->linkModel = new LinkModel($pdo);
		$this->boardModel = new BoardModel($pdo);
	}

	public function validateUrlLink($url) {
		if ( $url && !preg_match('~^https?://~i', $url) ) {
			$url = "http://$url";
		}
		return filter_var($url, FILTER_SANITIZE_URL);
	}

	public function showLinks($error = null) {
		$this->requireLogin();

		$user_id = $this->currentUserId;

		$boards = $this->boardModel->getBoardsByUser( $user_id );
		$links = $this->linkModel->getLinksByUser( $user_id );

		$this->render('links', [
			'error' => $error, 
			'boards' => $boards,
			'links' => $links
		]);
	}

	public function showEditLink($link = [], $boards = [], $error = null) {
		$this->requireLogin();

		$this->render('edit_link', [
			'link' => $link,
			'boards' => $boards,
			'error' => $error
		]);
	}

	// create new link
	public function storeLink() {
		$this->requireLogin();

		$title = trim($_POST['title'] ?? '');
		$url = $this->validateUrlLink( trim($_POST['url'] ?? '') );
		$description = trim($_POST['description'] ?? '');
		$board_id = (int) $_POST['board'] ?? 0;

		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			$this->showLinks('Invalid URL format.');
			exit;
		}
		if ( $title === '' ) {
			$this->showLinks('Title fields is required.');
			exit;
		}

		$link = $this->linkModel->createLink( $this->currentUserId, $title, $url, $description, $board_id );

		if ( $link ) {
			$_SESSION['link-crud-success'] = 'Link successfully created.';
			header('Location: index.php?action=showLinks');
			exit;
		} else {
			$this->showLinks('Error.');
		}
	}

	// edit link
	public function editLink() {
		$this->requireLogin();

		$linkId = (int) $_GET['id'] ?? 0;
		$user_id = $this->currentUserId;

		if ( !$linkId ) {
			$this->showLinks('ID link missing.');
			exit;
		}

		$link = $this->linkModel->getLinkById( $linkId, $user_id );
		$boards = $this->boardModel->getBoardsByUser( $user_id );

		if ( !$link ) {
			$this->showLinks('No link found.');
			exit;
		}

		$this->showEditLink($link, $boards);
	}

	// update link
	public function updateLink() {
		$this->requireLogin();

		$id = (int) $_POST['id'] ?? 0;
		$title = trim($_POST['title'] ?? '');
		$url = $this->validateUrlLink( trim($_POST['url'] ?? '') );
		$description = trim($_POST['description'] ?? '');
		$board_id = (int) $_POST['board'] ?? 0;

		if ( !$id ) {
			$this->showLinks('ID board missing.');
			exit;
		}

		$errors = [];
		if ( $title === '' ) {
			$errors['title'] = 'Title fields is required.';
		}
		if ( !filter_var($url, FILTER_VALIDATE_URL) ) {
			$errors['url'] = 'Invalid URL format.';
		}
		if ( !empty($errors) ) {
			$_SESSION['errors'] = $errors;
			$_SESSION['old'] = $_POST;
 
			header("Location: index.php?action=editLink&id=$id");
			exit;
	  	}

		$updated = $this->linkModel->updateLink( $id, $title, $url, $description, $board_id, $this->currentUserId );

		if ( $updated ) {
			$_SESSION['link-crud-success'] = 'Link successfully updated.';
			header('Location: index.php?action=showLinks');
			exit;
		} else {
			$_SESSION['errors'] = ['Update error.'];
			$_SESSION['old'] = $_POST;

			header("Location: index.php?action=editLink&id=$id");
			exit;
		}
	}

	// delete link
	public function deleteLink() {
		$this->requireLogin();

		$linkId = (int) $_POST['id'] ?? 0;

		if ( !$linkId ) {
			$this->showLinks('ID link missing.');
			exit;
		}

		$deleted = $this->linkModel->deleteLink( $this->currentUserId, $linkId );

		if ( $deleted ) {
			$_SESSION['link-crud-success'] = 'Link successfully deleted.';
			header('Location: index.php?action=showLinks');
			exit;
		} else {
			$this->showLinks('Link error deleting.');
		}
	}
}