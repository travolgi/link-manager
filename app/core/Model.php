<?php

class Model {
	protected $db;

	public function __construct($pdo) {
		$this->db=$pdo;
	}

	public function dbQuery($sql, $params = []) {
		$stmt = $this->db->prepare( $sql );
		$stmt->execute( $params );
		return $stmt;
	}
}