<?php
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../helpers/hash_string.php';

class UserModel extends Model {
	// check if the user exists
	public function userExists($username, $email, $excludeId = null) {
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
		if ( $excludeId ) {
			$sql .= ' AND id != :id';
			$params['id'] = $excludeId;
	  	}
		$stmt = $this->dbQuery($sql, $params);
		
		return $stmt->fetch();
	}
	
	// user registration
	public function register($username, $email, $password) {
		$userExists = $this->userExists( $username, $email );
		if ( $userExists ) {
			return false;
		}

		$hashedPw = hashString( $password );
		
		// create new user
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

	public function getPwUserById($user_id) {
		$sql = "
			SELECT password 
			FROM users 
			WHERE id = :user_id 
			LIMIT 1
		";
		$params = ['user_id' => $user_id];
		$stmt = $this->dbQuery($sql, $params);
		
		return $stmt->fetchColumn();
	}

	public function updateUser( $username, $email, $user_id ) {
		$userExists = $this->userExists( $username, $email, $user_id );
		if ( $userExists ) {
			return false;
		}

		$sql = "
			UPDATE users
			SET username = :username, email = :email, updated_at = NOW()
			WHERE id = :user_id
			LIMIT 1
		";
		$params = [
			'username' => $username, 
			'email' => $email, 
			'user_id' => $user_id
		];

		return $this->dbQuery($sql, $params);
	}

	public function updatePassword($password, $user_id) {
		$hashedPw = hashString( $password );

		$sql = "
			UPDATE users
			SET password = :password, updated_at = NOW()
			WHERE id = :user_id
			LIMIT 1
		";
		$params = [
			'password' => $hashedPw,
			'user_id' => $user_id
		];

		return $this->dbQuery($sql, $params);
	}

	public function deleteUser($user_id) {
		$sql = "
			DELETE
			FROM users 
			WHERE id = :user_id 
			LIMIT 1
		";
		$params = ['user_id' => $user_id];

		return $this->dbQuery($sql, $params);
	}
}