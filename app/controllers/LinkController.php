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

	public function showLinks($error = null) {
		$this->requireLogin();

		$boards = $this->boardModel->getBoardsByUser( currentUserId() );
		$links = $this->linkModel->getLinksByUser( currentUserId() );

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
		$url = filter_var( trim($_POST['url']), FILTER_SANITIZE_URL );
		$description = trim($_POST['description'] ?? '');
		$board_id = (int) $_POST['board'] ?? 0;
		$user_id = $this->currentUser['id'];

		if ( $title === '' || $url === '' ) {
			$this->showLinks('Title and Url fields are required.');
			exit;
		}

		$link = $this->linkModel->createLink( $user_id, $title, $url, $description, $board_id );

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
		$user_id = $this->currentUser['id'];

		if ( !$linkId ) {
			$this->showLinks('ID link missing.');
			exit;
		}

		$link = $this->linkModel->getLinkById( $linkId, $user_id );
		$boards = $this->boardModel->getBoardsByUser( currentUserId() );

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
		$url = filter_var( trim($_POST['url']), FILTER_SANITIZE_URL );
		$description = trim($_POST['description'] ?? '');
		$board_id = (int) $_POST['board'] ?? 0;
		$user_id = $this->currentUser['id'];

		if ( !$id ) {
			$this->showLinks('ID board missing.');
			exit;
		}

		if ( $title === '' || $url === '' ) {
			header("Location: index.php?action=editLink&id=$id&error=Title%20and%20Url%20fields%20are%20required.");
			exit;
		}

		$updated = $this->linkModel->updateLink($id, $title, $url, $description, $board_id, $user_id);

		if ( $updated ) {
			$_SESSION['link-crud-success'] = 'Link successfully updated.';
			header('Location: index.php?action=showLinks');
			exit;
		} else {
			header("Location: index.php?action=editLink&id=$id&error=Update%20error.");
		}
	}

	// delete link
	public function deleteLink() {
		$this->requireLogin();

		$linkId = (int) $_POST['id'] ?? 0;
		$user_id = $this->currentUser['id'];

		if ( !$linkId ) {
			$this->showLinks('ID link missing.');
			exit;
		}

		$deleted = $this->linkModel->deleteLink($user_id, $linkId);

		if ( $deleted ) {
			$_SESSION['link-crud-success'] = 'Link successfully deleted.';
			header('Location: index.php?action=showLinks');
			exit;
		} else {
			$this->showLinks('Link error deleting.');
		}
	}
}