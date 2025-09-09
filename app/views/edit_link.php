<a href="index.php?action=showLinks"><i class="fa-light fa-arrow-left"></i> Back</a>

<h2 class="font-bold text-3xl mt-4 mb-6">Edit Link</h2>

<?php if( isset($error) ) : ?>
	<p class="text-red-600 mb-6"><?= $error ?></p>
<?php endif; ?>

<form action="index.php?action=updateLink" method="POST" class="grid">
	<input type="hidden" name="id" value="<?= $link['id'] ?>">

	<label for="title">Link title:</label>
	<input
		type="text"
		name="title"
		id="title"
		placeholder="Enter Title Link"
		value="<?= $link['title'] ?>"
		required
	/>

	<label for="url">Link url:</label>
	<input
		type="text"
		name="url"
		id="url"
		placeholder="Enter url"
		value="<?= $link['url'] ?>"
		required
	/>

	<label for="description">Link description:</label>
	<textarea
		rows="3"
		name="description"
		id="description"
		placeholder="Enter Description Link"
	><?= $link['description'] ?></textarea>

	<label for="board">Board:</label>
	<select
		name="board"
		id="board"
		class="dark:bg-neutral-800"
	>
		<option value="null" <?php if ( !$link['board_id'] ) echo 'selected'; ?>>None</option>
		<?php if ( !empty($boards) ) : ?>
			<?php foreach($boards as $board) : ?>
				<option value="<?= $board['id'] ?>" <?php if ( $link['board_id'] == $board['id'] ) echo 'selected'; ?>><?= htmlspecialchars( $board['name'] ) ?></option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>

	<button type="submit" class="btn">Update link</button>
</form>