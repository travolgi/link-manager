<div class="grid mx-auto gap-6 p-6 max-w-sm card">
	<h2 class="font-bold text-3xl">Login</h2>

	<?php if( isset($error) ) : ?>
		<p class="text-red-600"><?= $error ?></p>
	<?php endif; ?>

	<?php if( isset( $_SESSION['register-user-success'] ) ) : ?>
		<p class="text-green-600"><?= $_SESSION['register-user-success'] ?></p>
		<?php unset($_SESSION['register-user-success']); ?>
	<?php endif; ?>

	<?php if( isset( $_GET['message'] ) ) : ?>
		<p class="text-green-600"><?= $_GET['message'] ?></p>
	<?php endif; ?>

	<form action="index.php?action=login" method="POST" class="grid gap-2">
		<?= Security::csrfField() ?>

		<label for="email">Email:</label>
		<input
			type="email"
			name="email"
			id="email"
			placeholder="Email"
			required
		/>

		<label for="password">Password:</label>
		<input
			type="password"
			name="password"
			id="password"
			placeholder="Password"
			required
		/>

		<button type="submit" class="btn mb-4">Login</button>

		<p>Don't have an account? <a href="index.php?action=showRegister" class="text-teal-600 font-semibold transition-all">Register now</a></p>
	</form>
</div>