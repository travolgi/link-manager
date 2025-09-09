<?php
require_once __DIR__ . '/../core/Model.php';

class LinkModel extends Model {
	public function getLinksByUser( $user_id ) {
		$sql = '
			SELECT * 
			FROM links
			WHERE user_id = :user_id
			ORDER BY created_at DESC
		';
		$params = [ 'user_id' => $user_id];
		$stmt = $this->dbQuery( $sql, $params );

		return $stmt->fetchAll();
	}

	public function getLinkById( $id, $user_id ) {
		$sql = '
			SELECT * 
			FROM links
			WHERE user_id = :user_id
			AND id = :id
			LIMIT 1
		';
		$params = [
			'user_id' => $user_id,
			'id' => $id
		];
		$stmt = $this->dbQuery( $sql, $params );

		return $stmt->fetch();
	}

	// create
	public function createLink( $user_id, $title, $url, $description, $board_id ) {
		$sql = '
			INSERT INTO links (user_id, title, url, description, board_id)
			VALUES(:user_id, :title, :url, :description, :board_id)
		';
		$params = [
			'user_id' => $user_id,
			'title' => $title,
			'url' => $url,
			'description' => $description,
			'board_id' => $board_id ?: NULL
		];
		return $this->dbQuery( $sql, $params );
	}

	// update
	public function updateLink( $id, $title, $url, $description, $board_id, $user_id ) {
		$sql = '
			UPDATE links 
			SET title = :title, url = :url, description = :description, board_id = :board_id, updated_at = NOW()
			WHERE id = :id
			AND user_id = :user_id
		';
		$params = [
			'id' => $id,
			'title' => $title,
			'url' => $url,
			'description' => $description,
			'board_id' => $board_id ?: NULL, 
			'user_id' => $user_id
		];
		return $this->dbQuery( $sql, $params );
	}

	// delete
	public function deleteLink( $user_id, $id ) {
		$sql = '
			DELETE FROM links
			WHERE user_id = :user_id
			AND id = :id
			LIMIT 1
		';
		$params = [
			'user_id' => $user_id,
			'id' => $id,
		];
		return $this->dbQuery( $sql, $params );
	}
}