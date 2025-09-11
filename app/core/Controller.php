<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/current_user_id.php';

class Controller {
	protected $userModel;
	protected $currentUser;
	protected $currentUserId;

	public function __construct($pdo) {
		$this->userModel = new UserModel($pdo);

		if ( currentUserId() ) {
			$this->currentUser = $this->userModel->getUserById( currentUserId() );
			$this->currentUserId = $this->currentUser['id'];
		}
	}

	// check if the user is logged in
	protected function requireLogin() {
		if ( !isset($_SESSION['user_id']) ) {
			header('Location: index.php?action=showLogin');
			exit;
		}
	}

	// render the view
	protected function render($viewName, $data = []) {
		$data['currentUser'] = $this->currentUser;
		extract($data, EXTR_SKIP);

		ob_start();
		require __DIR__ . "/../views/$viewName.php";
		$content = ob_get_clean();
		require __DIR__ . '/../views/layout.php';
	}
}