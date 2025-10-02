<div class="grid mx-auto gap-6 p-6 max-w-sm card">
	<h2 class="font-bold text-3xl">Registration</h2>

	<?php if( isset($error) ) : ?>
		<p class="text-red-600"><?= $error ?></p>
	<?php endif; ?>

	<form action="index.php?action=register" method="POST" class="grid gap-2">
		<label for="username">Username:</label>
		<input
			type="text"
			name="username"
			id="username"
			placeholder="Username"
			required
		/>

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
		
		<button type="submit" class="btn mb-4">Register</button>

		<p>Already have an account? <a href="index.php?action=showLogin" class="text-teal-600 font-semibold transition-all">Login now</a></p>
	</form>
</div>