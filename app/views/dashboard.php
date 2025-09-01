<div class="space-y-6">
	<h2 class="font-bold text-3xl">Welcome, <?= htmlspecialchars( $user['username'] ) ?>!</h2>
	
	<p>This is your dashboard.</p>
	
	<a href="index.php?action=showBoards" class="btn">All Boards</a>
	
	<a href="index.php?action=logout" class="block">Logout</a>
</div>