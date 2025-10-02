<?php
$orderby_values = [
	'DESC',
	'ASC',
	'A-Z',
	'Z-A'
];
?>

<select
	name="orderby"
	id="orderby"
	class="dark:bg-neutral-800"
>
	<?php foreach ($orderby_values as $value) : ?>
		<option
			value="<?= $value ?>"
			<?= ( $_GET['orderby'] ?? '' ) === $value ? 'selected' : '' ?>
		><?= $value ?></option>
	<?php endforeach; ?>
</select>