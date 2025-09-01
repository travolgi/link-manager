<?php
require_once __DIR__ . '/../core/Controller.php';

class DashboardController extends Controller {
	public function showDashboard() {
		$this->requireLogin();
		
		$this->render('dashboard');
	}
}