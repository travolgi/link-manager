<?php 
function slugify($text) {
	$text = strtolower(trim($text));
	$text = preg_replace('/[^a-z0-9-]/', '-', $text);
	$text = preg_replace('/-+/', '-', $text);
	return trim($text, '-');
}