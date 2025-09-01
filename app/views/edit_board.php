<a href="index.php?action=showBoards"><i class="fa-light fa-arrow-left"></i> Back</a>

<h2 class="font-bold text-3xl mt-4 mb-6">Edit Board</h2>

<?php if( isset($error) ) : ?>
	<p class="text-red-600 mb-6"><?= $error ?></p>
<?php endif; ?>

<form action="index.php?action=updateBoard" method="POST" class="grid">
	<input type="hidden" name="id" value="<?= $board['id'] ?>">

	<label for="name">Board name:</label>
	<input
		type="text"
		name="name"
		id="name"
		placeholder="Board Name"
		value="<?= htmlspecialchars($board['name']) ?>"
		required
	/>

	<button type="submit" class="btn">Update board</button>
</form>