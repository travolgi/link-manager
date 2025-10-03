<div class="max-w-3xl m-auto space-y-6">
	<a href="index.php?action=showProfile" class="btn-secondary"><i class="fa-light fa-arrow-left"></i> Back</a>

	<h2 class="font-bold text-3xl mt-4">Edit Profile</h2>

	<?php if( isset($_SESSION['errors']) ) : ?>
		<p class="text-red-600 mb-6"><?= $_SESSION['errors'] ?></p>
		<?php
			unset($_SESSION['errors']);
			unset($_SESSION['old']);
		?>
	<?php endif; ?>

	<form action="index.php?action=updateProfile" method="POST" class="grid">
		<?= Security::csrfField() ?>

		<label for="username">Username:</label>
		<input
			type="text"
			name="username"
			id="username"
			placeholder="Enter Username"
			value="<?= htmlspecialchars( $currentUser['username'] ) ?>"
			required
		/>

		<label for="email">Email:</label>
		<input
			type="email"
			name="email"
			id="email"
			placeholder="Enter email"
			value="<?= htmlspecialchars( $currentUser['email'] ) ?>"
			required
		/>

		<button type="submit" class="btn">Update Profile</button>
	</form>
</div>