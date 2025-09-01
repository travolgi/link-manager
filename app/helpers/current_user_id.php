<?php
function currentUserId(): int {
	return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
}