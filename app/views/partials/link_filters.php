<form action="index.php" method="GET" class="flex items-end gap-4 mb-4">
	<input
		type="hidden"
		name="action"
		id="action"
		value="showLinks"
	/>

	<div>
		<label for="search">Search by:</label>
		<div class="relative">
			<i class="fa-light fa-search absolute left-2 top-3"></i>
			<input
				type="text"
				name="search"
				id="search"
				placeholder="Title, Url, Description or Board"
				value="<?= htmlspecialchars( trim( $_GET['search'] ?? '' ) ) ?>"
				class="pl-8 leading-0"
			/>
		</div>
	</div>

	<div>
		<label for="orderby">Order by:</label>
		<?php
		require __DIR__ . '/field_select_orderby.php';
		?>
	</div>

	<button type="submit" class="btn mb-4">Apply</button>

	<?php if ( !empty( $_GET['search'] ) || !empty( $_GET['orderby'] ) ): ?>
		<a href="index.php?action=showLinks" class="font-semibold opacity-65 py-2 mb-4"><i class="fa-light fa-x"></i>
		Reset</a>
	<?php endif; ?>
</form>

<?php if ( isset( $_GET['search'] ) && trim( $_GET['search'] ) ) : ?>
	<p class="opacity-65 -mt-5 mb-6"><?=count($links)?> results found for "<?= htmlspecialchars( $_GET['search'] ?? '' ) ?>".</p>
<?php endif; ?>