<div id="newlink-modal" class="fixed inset-0 bg-black/65 p-4 overflow-y-scroll !hidden flex justify-center items-center transition-all">
	<div class="relative w-3xl bg-white dark:bg-neutral-800 dark:text-white/90 py-6 card">
		<i id="close-newlink-modal" class="fa-light fa-x text-sm absolute top-3 right-4 hover:opacity-65 transition-all"></i>
		
		<h3 class="font-bold text-xl mb-4">Create New Link</h3>
		<form action="index.php?action=storeLink" method="POST" class="grid">
		 	<?= Security::csrfField() ?>
		
			<input
				type="hidden"
				name="redirect_to"
				id="redirect_to"
				value="<?= $redirect_to ?? 'links' ?>"
			/>

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
			<?php
			require __DIR__ . '/field_select_board.php';
			?>

			<button type="submit" class="btn">Create link</button>
		</form>
	</div>
</div>