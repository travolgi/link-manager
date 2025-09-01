<?php
require_once __DIR__ . '/../core/Controller.php';

class AuthController extends Controller {
	public function showLogin($error = null) {
		$this->render('login', ['error' => $error]);
	}
	
	public function showRegister($error = null) {
		$this->render('register', ['error' => $error]);
	}

	// user login
	public function login() {
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';
		$user = $this->userModel->login($email, $password);

		if ( $user ) {
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $user['username'];

			header('Location: index.php?action=dashboard');
			exit;
		} else {
			$this->showLogin('Email or password incorrect.');
		}
	}

	// user registration
	public function register() {
		$username = trim($_POST['username'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';

		if ( $username === '' ) {
			$this->showRegister('Username is required.');
		}

		$user = $this->userModel->register($username, $email, $password);

		if ( $user ) {
			$_SESSION['register-user-success'] = 'User registration successful. Log in now!';
			header('Location: index.php?action=showLogin');
			exit;
		} else {
			$this->showRegister('Username or email already exists.');
		}
	}

	public function logout() {
		session_unset();
		session_destroy();

		header('Location: index.php?action=showLogin');
		exit;
	}
}
