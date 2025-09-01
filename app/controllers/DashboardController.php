<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../helpers/current_user_id.php';

class DashboardController extends Controller {
	public function showDashboard() {
		$this->requireLogin();

		$user = $this->userModel->getUserById( currentUserId() );

		$this->render('dashboard', ['user' => $user]);
	}
}