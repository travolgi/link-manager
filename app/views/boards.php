<h2 class="font-bold text-3xl mb-6">Boards</h2>

<?php $redirect_to= 'boards' ?>

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
			<p class="text-sm text-black/25 dark:text-white/25 italic">No boards.</p>
		<?php else : ?>
			<?php foreach ($boards as $board) : ?>
				<div class="card">
					<div class="grid grid-cols-[1fr_1rem_1rem] items-center justify-between gap-4 mb-4">
						<h3 class="font-semibold text-xl"><?= htmlspecialchars($board['name']) ?></h3>

						<a href="index.php?action=editBoard&id=<?= $board['id']; ?>" title="Edit">
							<i class="fa-light fa-pen hover:text-teal-800 transition-all"></i>
						</a>

						<form action="index.php?action=deleteBoard" method="POST" onsubmit="return confirm('Are you sure you want to delete this board?')">
						<?= Security::csrfField() ?>	
						<input type="hidden" name="id" value="<?= $board['id'] ?>">
							<button type="submit" title="Delete">
								<i class="fa-light fa-trash text-red-300 hover:text-red-600 transition-all"></i>
							</button>
						</form>
					</div>
					<!-- board links -->
					<ul class="space-y-2">
						<?php if ( empty( $boardsLinks[$board['id']] ) ) : ?>
							<li class="text-sm text-black/25 dark:text-white/25 italic">No links yet.</li>
						<?php else : ?>
							<?php foreach ($boardsLinks[$board['id']] as $link) : ?>
								<li>
									<a
										href="<?= htmlspecialchars( $link['url'] ) ?>" 
										target="_blank"
										rel="nofollow noopener noreferrer"
										class="hover:text-teal-800 transition-all"
									>
										<?= htmlspecialchars( $link['title'] ) ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					<button class="btn-secondary open-newlink-modal" data-board-id="<?= $board['id'] ?>"><i class="fa-light fa-plus"></i> New link</button>
				</div>
			<?php endforeach; ?>

			<div class="card bg-neutral-800/5 dark:bg-white/5">
				<div class="mb-4">
					<h3 class="font-semibold text-xl mb-4">General</h3>
				</div>
				<!-- links without board -->
				<ul class="space-y-2">
					<?php if ( empty( $boardsLinks['null'] ) ) : ?>
						<li class="text-sm text-black/25 dark:text-white/25 italic">No links yet.</li>
					<?php else : ?>
						<?php foreach ($boardsLinks['null'] as $link) : ?>
							<li>
								<a
									href="<?= htmlspecialchars( $link['url'] ) ?>" 
									target="_blank"
									rel="nofollow noopener noreferrer"
									class="hover:text-teal-800 transition-all"
								>
									<?= htmlspecialchars( $link['title'] ) ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>

	<form action="index.php?action=storeBoard" method="POST" class="grid">
		<h3 class="font-bold text-xl mb-4">Create New Board</h3>

		<?= Security::csrfField() ?>

		<label for="name">Board name:</label>
		<input
			type="text"
			name="name"
			id="name"
			placeholder="Enter Board Name"
			required
		/>

		<button type="submit" class="btn">Create new board</button>
	</form>

</div>