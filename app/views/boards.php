<h2 class="font-bold text-3xl mb-6">Boards</h2>

<?php if( isset($error) ) : ?>
	<p class="text-red-600 mb-6"><?= $error ?></p>
<?php endif; ?>

<?php if( isset( $_SESSION['board-crud-success'] ) ) : ?>
	<p class="text-green-600 mb-6"><?= $_SESSION['board-crud-success'] ?></p>
	<?php unset($_SESSION['board-crud-success']); ?>
<?php endif; ?>

<div class="grid md:grid-cols-[2fr_1fr] items-start gap-6">

	<div class="grid md:grid-cols-3 gap-6">
		<?php if ( empty($boards) ) : ?>
			<p>No boards.</p>
		<?php else : ?>
			<?php foreach ($boards as $board) : ?>
				<div class="border border-neutral-300 dark:border-white/20 p-4 rounded-md">
					<div class="flex items-center justify-between gap-4 mb-4">
						<h3 class="font-semibold text-xl"><?= htmlspecialchars($board['name']) ?></h3>

						<div class="grid grid-cols-2 gap-4">
							<a href="index.php?action=editBoard&id=<?= $board['id']; ?>" title="Edit">
								<i class="fa-light fa-pen"></i>
							</a>

							<form action="index.php?action=deleteBoard" method="POST">
								<input type="hidden" name="id" value="<?= $board['id'] ?>">
								<button type="submit" title="Delete">
									<i class="fa-light fa-trash text-red-300 hover:text-red-600"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<form action="index.php?action=storeBoard" method="POST" class="grid">
		<label for="name">Board name:</label>
		<input
			type="text"
			name="name"
			id="name"
			placeholder="Board Name"
			required
		/>

		<button type="submit" class="btn">Create new board</button>
	</form>

</div>