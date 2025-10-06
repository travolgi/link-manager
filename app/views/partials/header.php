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
	<header class="relative flex items-center justify-between md:justify-evenly gap-6 p-4 border-b border-neutral-300 dark:border-white/20">
		<div class="flex items-center justify-center gap-2">
			<i class="fa-light fa-link text-teal-600 text-4xl"></i>
			<span class="font-semibold leading-5">Link<br>Manager</span>
		</div>

		<!-- navigation -->
		<nav class="hidden absolute top-20 right-4 py-6 px-8 card md:relative md:top-0 md:flex md:p-0 md:border-0 bg-white/90 dark:bg-neutral-800/90 md:bg-transparent z-40" id="navbar" data-visible="false">
			<ul class="flex flex-col md:flex-row md:items-center gap-4">
				<li>
					<a href="/" class="hover:text-teal-800 transition-all">Home</a>
				</li>
				<?php if ( isset($_SESSION['user_id']) ) : ?>
					<li>
						<a href="index.php?action=dashboard" class="hover:text-teal-800 transition-all">Dashboard</a>
					</li>
					<li>
						<a href="index.php?action=showBoards" class="hover:text-teal-800 transition-all">Boards</a>
					</li>
					<li>
						<a href="index.php?action=showLinks" class="hover:text-teal-800 transition-all">Links</a>
					</li>
					<li>
						<a href="#" class="btn open-newlink-modal" data-board-id=""><i class="fa-light fa-plus"></i> New Link</a>
					</li>
					<li>
						<a href="index.php?action=showProfile" class="hover:text-teal-800 transition-all">
							<i class="fa-light fa-user px-2"></i> <?= htmlspecialchars( $currentUser['username'] ) ?>
						</a>
					</li>
				<?php else : ?>
					<li>
						<a href="index.php?action=showLogin" class="hover:text-teal-800 transition-all">
							<i class="fa-light fa-user px-2"></i>
							Login
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>

		<div class="flex items-center justify-center gap-4">
			<button class="flex justify-end md:hidden" id="nav-toggle" aria-controls="navbar" aria-expanded="false">
				<i class="fa-light fa-bars text-2xl" id="nav-toggle-open"></i>
				<i class="fa-light fa-xmark text-2xl hidden" id="nav-toggle-close"></i>
			</button>

			<button id="ui-theme">
				<i class="fa-light fa-sun px-2 hidden dark:block"></i>
				<i class="fa-light fa-moon px-2 dark:hidden"></i>
			</button>
		</div>
	</header>

	<main class="min-h-[80vh] py-18 px-4">