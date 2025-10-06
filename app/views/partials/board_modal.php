<div id="newboard-modal" class="fixed inset-0 bg-black/65 p-4 overflow-y-scroll !hidden flex justify-center items-center transition-all z-50">
	<div class="relative w-3xl bg-white dark:bg-neutral-800 dark:text-white/90 py-6 card">
		<i class="fa-light fa-x text-sm absolute top-3 right-4 hover:opacity-65 transition-all close-modal"></i>
		
		<h3 class="font-bold text-xl mb-4">Create New Board</h3>
		<form action="index.php?action=storeBoard" method="POST" class="grid">
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
</div>