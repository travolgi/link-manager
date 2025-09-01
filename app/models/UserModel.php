<?php
require_once __DIR__ . '/../core/Model.php';

class UserModel extends Model {
	// user registration
	public function register($username, $email, $password) {
		// check if the user exists
		$sql = '
			SELECT id
			FROM users
			WHERE username = :username 
			OR email = :email
		';
		$params = [
			'username' => $username,
			'email' => $email
		];
		$stmt = $this->dbQuery($sql, $params);
		$userExists = $stmt->fetch();

		if ( $userExists ) {
			return false;
		}

		// create new user
		$hashedPw = password_hash($password, PASSWORD_DEFAULT);

		$sql = '
			INSERT INTO users (username, email, password)
			VALUES (:username, :email, :password)
		';
		$params = [
			'username' => $username,
			'email' => $email,
			'password' => $hashedPw
		];
		return $this->dbQuery($sql, $params);
	}

	// user login
	public function login($email, $password) {
		// return user
		$sql = "
			SELECT *
			FROM users
			WHERE email = :email
			LIMIT 1
		";
		$params = ['email' => $email];
		$stmt = $this->dbQuery($sql, $params);
		$user = $stmt->fetch();

		// verify password
		if ($user && password_verify($password, $user['password'])) {
			return $user;
		}

		return false;
	}

	public function getUserById($id) {
		$sql = "
			SELECT id, username, email 
			FROM users 
			WHERE id = :id 
			LIMIT 1
		";
		$params = ['id' => $id];
		$stmt = $this->dbQuery($sql, $params);
		
		return $stmt->fetch();
	}
}