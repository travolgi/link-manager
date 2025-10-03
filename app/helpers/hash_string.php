<?php 
function hashString( $string ) {
	return password_hash($string, PASSWORD_DEFAULT);
}