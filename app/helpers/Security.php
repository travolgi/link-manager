<?php

class Security {
	public static function generateCsrfToken() {
		if ( empty( $_SESSION['csrf_token'] ) ) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
		return $_SESSION['csrf_token'];
	}

	public static function validateCsrfToken( $token ) {
		return isset( $_SESSION['csrf_token'] ) && hash_equals( $_SESSION['csrf_token'] , $token );
	}

	public static function csrfField() {
		return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars( self::generateCsrfToken() ) . '">';
	}
}