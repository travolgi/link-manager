<?php $userId = $currentUser['id']; ?>

<div class="max-w-3xl m-auto space-y-6">
	<h2 class="font-bold text-3xl">Your Profile</h2>

	<?php if( isset($error) ) : ?>
		<p class="text-red-600"><?= $error ?></p>
	<?php endif; ?>

	<?php if( isset( $_SESSION['profile-crud-success'] ) ) : ?>
		<p class="text-green-600"><?= $_SESSION['profile-crud-success'] ?></p>
		<?php unset($_SESSION['profile-crud-success']); ?>
	<?php endif; ?>

	<div class="card grid md:grid-cols-2 items-start gap-4 mb-10">
		<div>
			<h4 class="opacity-65">Your Username</h4>
			<div class="text-lg"><?= htmlspecialchars( $currentUser['username'] ) ?></div>

			<h4 class="opacity-65 mt-4">Your Email</h4>
			<div class="text-lg"><?= htmlspecialchars( $currentUser['email'] ) ?></div>

			<h4 class="opacity-65 mt-4">Your Password</h4>
			<a href="index.php?action=changePassword" class="text-lg hover:text-teal-800 transition-all"><i class="fa-light fa-key mr-2"></i>Change password</a>
		</div>

		<div class="grid md:justify-self-end space-y-10">
			<a href="index.php?action=logout" class="btn-secondary text-base">
				<i class="fa-light fa-arrow-right-from-bracket"></i> Logout
			</a>
			<a href="index.php?action=editProfile" class="btn">
				<i class="fa-light fa-pen"></i> Edit profile
			</a>
		</div>
	</div>

	<div class="flex items-center justify-around gap-6">
		<form action="index.php?action=deleteProfile" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? Irreversible action: all data will be lost forever.')">
			<?= Security::csrfField() ?>
			<button type="submit" class="text-red-300 hover:text-red-600 transition-all">
				<i class="fa-light fa-trash"></i> Delete my account
			</button>
		</form>
	</div>
</div>