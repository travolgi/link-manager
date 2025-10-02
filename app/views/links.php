<h2 class="font-bold text-3xl mb-6">Links</h2>

<?php if( isset($error) ) : ?>
	<p class="text-red-600 mb-6"><?= $error ?></p>
<?php endif; ?>

<?php if( isset($_SESSION['link-crud-success']) ) : ?>
	<p class="text-green-600 mb-6"><?= $_SESSION['link-crud-success'] ?></p>
	<?php unset($_SESSION['link-crud-success']); ?>
<?php endif; ?>

<?php 
require __DIR__ . '/partials/link_filters.php';
?>

<div class="grid md:grid-cols-2 items-start gap-6">
	<div class="space-y-2">

	<?php if ( empty($links) ) : ?>
		<p class="text-sm text-black/25 dark:text-white/25 italic">No links.</p>
	<?php else :?>
		<?php foreach ($links as $link) : ?>
			<div class="border border-neutral-300 dark:border-white/20 p-2 rounded-md">
				<div class="grid grid-cols-[1fr_1rem_1rem] gap-4 mb-1">
					<span class="font-semibold text-lg"><?= htmlspecialchars( $link['title'] ) ?></span>
					
					<a href="index.php?action=editLink&id=<?= $link['id'] ?>" title="Edit">
						<i class="fa-light fa-pen"></i>
					</a>

					<form action="index.php?action=deleteLink" method="POST" 
					onsubmit="return confirm('Are you sure you want to delete this link?')">
						<input type="hidden" name="id" value="<?= $link['id'] ?>">
						<button type="submit" title="Delete">
							<i class="fa-light fa-trash text-red-300 hover:text-red-600"></i>
						</button>
					</form>
				</div>
				<!--link data	-->
				<div class="flex flex-col items-start gap-2">
					<?php $url = htmlspecialchars( $link['url'] ) ?>
					<a
						href="<?= $url ?>" 
						target="_blank"
						rel="nofollow noopener noreferrer"
						class="text-teal-600 hover:text-teal-800 italic transition-all"
					>
						<?= $url ?>
					</a>
					<?php if ( $link['description'] !== '' ) : ?>
						<p><?= htmlspecialchars( $link['description'] ) ?></p>
					<?php endif; ?>
					<?php if ( isset($link['board_name']) ) : ?>
						<span class="rounded-md bg-teal-600/15 p-1"><?= htmlspecialchars( $link['board_name'] ) ?></span>
					<?php endif; ?>
					<span class="text-xs">Created at: <?= $link['created_at'] ?></span>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif;?>

	</div>

	<form action="index.php?action=storeLink" method="POST" class="grid">
		<label for="title">Link title:</label>
		<input
			type="text"
			name="title"
			id="title"
			placeholder="Enter Title Link"
			required
		/>

		<label for="url">Link url:</label>
		<input
			type="text"
			name="url"
			id="url"
			placeholder="Enter url"
			required
		/>

		<label for="description">Link description:</label>
		<textarea
			rows="3"
			name="description"
			id="description"
			placeholder="Enter Description Link"
		></textarea>

		<label for="board">Board:</label>
		<select
			name="board"
			id="board"
			class="dark:bg-neutral-800"
		>
			<option value="null" default>None</option>
			<?php if ( !empty($boards) ) : ?>
				<?php foreach($boards as $board) : ?>
					<option value="<?= $board['id'] ?>"><?= htmlspecialchars( $board['name'] ) ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>

		<button type="submit" class="btn">Create new link</button>
	</form>
</div>