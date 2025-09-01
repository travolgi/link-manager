<!DOCTYPE html>
<html lang="en" class="dark">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/imgs/favicon.ico" />
	<meta name="author" content="Travolgi">
	<title>Link Manager</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dark:bg-neutral-800 dark:text-white/90">
	<header class="flex items-center justify-evenly gap-6 p-4 border-b border-neutral-300 dark:border-white/20">
		<div class="flex items-center justify-center gap-2">
			<i class="fa-light fa-link text-teal-600 text-4xl"></i>
			<span class="font-semibold leading-5">Link<br>Manager</span>
		</div>

		<nav>
			<ul class="flex items-center gap-4">
				<li>
					<a href="/">Home</a>
				</li>
				<?php if ( isset($_SESSION['user_id']) ) : ?>
					<li>
						<a href="index.php?action=dashboard">Dashboard</a>
					</li>
					<li>
						<a href="index.php?action=showBoards">Boards</a>
					</li>
					<li>
						<a href="#">
							<i class="fa-light fa-user px-2"></i>
							User: <?= htmlspecialchars( $currentUser['username'] ) ?>
						</a>
					</li>
					<li>
						<a href="index.php?action=logout">Logout</a>
					</li>
				<?php else : ?>
					<li>
						<a href="index.php?action=showLogin">
							<i class="fa-light fa-user px-2"></i>
							Login
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>

		<button id="ui-theme">
			<i class="fa-light fa-sun px-2 hidden dark:block"></i>
			<i class="fa-light fa-moon px-2 dark:hidden"></i>
		</button>
	</header>

	<main class="min-h-[80vh] py-18 px-4">