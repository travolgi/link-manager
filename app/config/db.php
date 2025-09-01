<?php
require_once 'config.php';

try {
	$dns = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
	$pdo = new PDO( $dns, DB_USER, DB_PW );
	
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
} catch (PDOException $err) {
	die ("DB connection error: " . $err->getMessage());
}