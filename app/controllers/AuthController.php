<?php
require_once __DIR__ . '/../core/Controller.php';

class AuthController extends Controller {
	public function showLogin($error = null) {
		$this->render('login', ['error' => $error]);
	}
	
	public function showRegister($error = null) {
		$this->render('register', ['error' => $error]);
	}

	public function showProfile($error = null) {
		$this->requireLogin();
		$this->render('profile', ['error' => $error]);
	}

	public function showEditProfile($error = null) {
		$this->requireLogin();
		$this->render('edit_profile', ['error' => $error]);
	}

	public function showChangePassword($error = null) {
		$this->requireLogin();
		$this->render('change_password', ['error' => $error]);
	}
	
	public function validateUserData( $username, $email ) {
		$errors = [];
		if ( $username === '' ) {
			$errors['username'] = 'Username fields is required.';
		}
		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$errors['email'] = 'Invalid Email format.';
		}
		return join('<br>', $errors);
	}

	// user login
	public function login() {
		$this->checkCsrfToken();

		$email = trim( $_POST['email'] ?? '' );
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
		$this->checkCsrfToken();
		
		$username = trim( $_POST['username'] ?? '' );
		$email = trim( $_POST['email'] ?? '' );
		$password = $_POST['password'] ?? '';

		$errors = $this->validateUserData( $username, $email );
		if ( !empty($errors) ) {
			$this->showRegister( $errors );
			exit;
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

	// logout and destroy session
	public function logout() {
		session_unset();
		session_destroy();

		header('Location: index.php?action=showLogin');
		exit;
	}
	
	// update account info
	public function updateProfile() {
		$this->requireLogin();
		$this->checkCsrfToken();

		$username = trim( $_POST['username'] ?? '' );
		$email = trim( $_POST['email'] ?? '' );

		$errors = $this->validateUserData( $username, $email );
		if ( !empty($errors) ) {
			$_SESSION['errors'] = $errors;
			$_SESSION['old'] = $_POST;
 
			header("Location: index.php?action=editProfile");
			exit;
	  	}

		$updated = $this->userModel->updateUser( $username, $email, $this->currentUserId );

		if ( $updated ) {
			$_SESSION['username'] = $username;
			$_SESSION['profile-crud-success'] = 'Profile successfully updated.';
			header('Location: index.php?action=showProfile');
			exit;
		} else {
			$_SESSION['errors'] = 'Username or email already exists.';
			$_SESSION['old'] = $_POST;
			header('Location: index.php?action=editProfile');
			exit;
		}
	}

	// update account password
	public function updatePassword() {
		$this->requireLogin();
		$this->checkCsrfToken();

		$password = $_POST['password'] ?? '';
		$confirmPassword = $_POST['confirm_password'] ?? '';

		if ( $password === '' ) {
			$_SESSION['errors'] = 'Password invalid.';
			header("Location: index.php?action=changePassword");
			exit;
	  	}
		if ($password !== $confirmPassword) {
			$_SESSION['errors'] = 'Passwords do not match.';
			header("Location: index.php?action=changePassword");
			exit;
	  	}

		$updated = $this->userModel->updatePassword( $password, $this->currentUserId );

		if ( $updated ) {
			$_SESSION['profile-crud-success'] = 'Password successfully updated.';
			header('Location: index.php?action=showProfile');
			exit;
		} else {
			$_SESSION['errors'] = 'Update password error.';
			header('Location: index.php?action=changePassword');
			exit;
		}
	}
	
	// delete account
	public function deleteProfile() {
		$this->requireLogin();
		$this->checkCsrfToken();

		$accountId = (int) $this->currentUserId;

		if ( !$accountId ) {
			$this->showProfile('Account ID missing.');
			exit;
		}

		if ( $accountId !== (int) $this->currentUserId ) {
			$this->showProfile('Account ID is wrong.');
			exit;
		}

		$deleted = $this->userModel->deleteUser( $accountId );

		if ( $deleted ) {
			session_unset();
			session_destroy();
			header('Location: index.php?action=showLogin&message=Account successfully deleted.');
			exit;
		} else {
			$this->showProfile('Account error deleting.');
			exit;
		}
	}
}