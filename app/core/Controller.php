<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/UserModel.php';

class Controller {
	protected $userModel;

	public function __construct($pdo) {
		$this->userModel = new UserModel($pdo);
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
		extract($data, EXTR_SKIP);

		ob_start();
		require __DIR__ . "/../views/$viewName.php";
		$content = ob_get_clean();
		require __DIR__ . '/../views/layout.php';
	}
}