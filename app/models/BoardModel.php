<?php
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../helpers/slugify.php';

class BoardModel extends Model {
	public function getBoardsByUser($user_id) {
		$sql = '
			SELECT *
			FROM boards
			WHERE user_id = :user_id
			ORDER BY created_at DESC
		';
		$params = ['user_id' => $user_id];
		$stmt = $this->dbQuery($sql, $params);
		
		return $stmt->fetchAll();
	}

	public function getBoardById($id, $user_id) {
		$sql = '
			SELECT *
			FROM boards
			WHERE id = :id
			AND user_id = :user_id
			LIMIT 1
		';
		$params = [
			'id' => $id,
			'user_id' => $user_id
		];
		$stmt = $this->dbQuery($sql, $params);

		return $stmt->fetch();
	}

	public function getBoardExists($user_id, $name, $slug, $excludeId = null) {
		$sql = '
			SELECT id
			FROM boards
			WHERE user_id = :user_id
			AND (name = :name OR slug = :slug)
		';
		$params = [
			'user_id' => $user_id,
			'name' => $name,
			'slug' => $slug,
		];
		if ($excludeId) {
			$sql .= " AND id != :excludeId";
			$params['excludeId'] = $excludeId;
	  	}
		$stmt = $this->dbQuery($sql, $params);

		return $stmt->fetch();
	}

	// create
	public function createBoard($user_id, $name) {
		$slug = slugify($name);
		
		// check if the board exists
		$boardExists = $this->getBoardExists($user_id, $name, $slug);

		if ( $boardExists ) {
			return false;
		}

		// create new board
		$sql = '
			INSERT INTO boards (name, slug, user_id)
			VALUES (:name, :slug, :user_id)
		';
		$params = [
			'name' => $name,
			'slug' => $slug,
			'user_id' => $user_id
		];
		return $this->dbQuery($sql, $params);
	}

	// update
	function updateBoard($id, $name, $user_id) {
		$slug = slugify($name);

		// check if the board exists
		$boardExists = $this->getBoardExists($user_id, $name, $slug, $id);

		if ( $boardExists ) {
			return false;
		}

		// update board
		$sql = '
			UPDATE boards 
			SET name = :name, slug = :slug, updated_at = NOW()
			WHERE id = :id AND user_id = :user_id
		';
		$params = [
			'id' => $id,
			'name' => $name,
			'slug' => $slug,
			'user_id' => $user_id

		];
		return $this->dbQuery($sql, $params);
	}

	// delete
	public function deleteBoard($id, $user_id) {
		$sql = '
			DELETE FROM boards 
			WHERE id = :id AND user_id = :user_id
		';
		$params = [
			'id' => $id,
			'user_id' => $user_id
	];
		return $this->dbQuery($sql, $params);
	}
}