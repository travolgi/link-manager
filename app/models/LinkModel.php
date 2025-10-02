<?php
require_once __DIR__ . '/../core/Model.php';

class LinkModel extends Model {
	public function getLinksByUser( $user_id, $query = null, $orderby = null ) {
		$sql = '
			SELECT links.*, boards.name AS board_name
			FROM links
			LEFT JOIN boards ON links.board_id = boards.id
			WHERE links.user_id = :user_id
		';
		$params = [ 'user_id' => $user_id];

		if ( $query ) {
			$sql .= ' AND (
				links.title LIKE :q OR
				links.url LIKE :q OR
				links.description LIKE :q OR
				boards.name LIKE :q
			)';
			$params['q'] = '%' . $query . '%';
		}

		switch ($orderby) {
			case 'ASC':
				$sql .= ' ORDER BY links.created_at ASC';
				break;
			case 'A-Z':
				$sql .= ' ORDER BY links.title ASC';
				break;
			case 'Z-A':
				$sql .= ' ORDER BY links.title DESC';
				break;
			
			default:
				$sql .= ' ORDER BY links.created_at DESC';
				break;
		}

		$stmt = $this->dbQuery( $sql, $params );

		return $stmt->fetchAll();
	}

	public function getLinksByBoard( $user_id, $board_id = null ) {
		$sql = '
			SELECT *
			FROM links
			WHERE user_id = :user_id 
		';
		$params = [ 'user_id' => $user_id ];
		
		if ( $board_id === null ) {
			$sql .= ' AND board_id IS NULL';
		} else {
			$sql .= ' AND board_id = :board_id';
			$params['board_id'] = $board_id;
		}
		$sql .= ' ORDER BY created_at DESC';
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