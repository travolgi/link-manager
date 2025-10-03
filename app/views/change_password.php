<div class="max-w-3xl m-auto space-y-6">
	<a href="index.php?action=showProfile" class="btn-secondary"><i class="fa-light fa-arrow-left"></i> Back</a>

	<h2 class="font-bold text-3xl mt-4">Change Password</h2>

	<?php if( isset($_SESSION['errors']) ) : ?>
		<p class="text-red-600 mb-6"><?= $_SESSION['errors'] ?></p>
		<?php
			unset($_SESSION['errors']);
		?>
	<?php endif; ?>

	<form action="index.php?action=updatePassword" method="POST" class="grid">
		<?= Security::csrfField() ?>

		<label for="password">New password:</label>
		<input
			type="password"
			name="password"
			id="password"
			placeholder="Enter new password"
			required
		/>

		<label for="password">Confirm new password:</label>
		<input
			type="password"
			name="confirm_password"
			id="confirm_password"
			placeholder="Enter new password"
			required
		/>

		<button type="submit" class="btn">Update Password</button>
	</form>
</div>