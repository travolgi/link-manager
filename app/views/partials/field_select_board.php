<select
	name="board"
	id="board"
	class="dark:bg-neutral-800"
>
	<option value="null">None</option>
	<?php if ( !empty($boards) ) : ?>
		<?php foreach($boards as $board) : ?>
			<option value="<?= $board['id'] ?>"><?= htmlspecialchars( $board['name'] ) ?></option>
		<?php endforeach; ?>
	<?php endif; ?>
</select>