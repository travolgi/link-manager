<div class="max-w-3xl m-auto space-y-6">
	<h2 class="font-bold text-3xl">Welcome, <span class="text-teal-600"><?= htmlspecialchars( $currentUser['username'] ) ?></span>!</h2>
	
	<p>Overview of your saves.</p>

	<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
		<div class="card">
			<h4 class="opacity-65 mb-2">Total Links</h4>
			<span class="block text-center font-bold text-5xl"><?= $stats['total_links'] ?></span>
			<a href="index.php?action=showLinks" class="btn-secondary float-end"><i class="fa-light fa-eye"></i> All Links</a>
		</div>

		<div class="card">
			<h4 class="opacity-65 mb-2">Total Boards</h4>
			<span class="block text-center font-bold text-5xl"><?= $stats['total_boards'] ?></span>
			<div class="flex flex-wrap items-center justify-end gap-2 mt-4">
				<a href="#" class="btn-secondary mt-0 open-board-modal"><i class="fa-light fa-plus"></i> New Board</a>
				<a href="index.php?action=showBoards" class="btn-secondary mt-0"><i class="fa-light fa-eye"></i> All Boards</a>
			</div>
		</div>

		<div class="card">
			<h4 class="opacity-65 mb-2">Average links/board</h4>
			<span class="block text-center font-bold text-5xl"><?= $stats['avg_links'] ?></span>
		</div>
	</div>

	<div class="card">
		<div class="flex items-center justify-between gap-4 mb-2">
			<h4 class="opacity-65">Recent Links</h4>

			<button class="btn-secondary text-teal-400 open-newlink-modal" data-board-id=""><i class="fa-light fa-plus"></i> New link</button>
		</div>

		<ul class="space-y-2">
			<?php if ( empty( $recentLinks ) ) : ?>
				<li class="text-sm text-black/25 dark:text-white/25 italic">No links yet.</li>
			<?php else : ?>
				<?php foreach ($recentLinks as $link) : ?>
					<li class="grid justify-start gap-1 py-2 border-b border-neutral-300 dark:border-white/20">
						<a
							href="<?= htmlspecialchars( $link['url'] ) ?>" 
							target="_blank"
							rel="nofollow noopener noreferrer"
							class="text-lg font-semibold italic hover:text-teal-800 transition-all"
						>
							<?= htmlspecialchars( $link['title'] ) ?>
							<i class="fa-light fa-up-right-from-square text-sm pl-1"></i>
						</a>

						<?php if ( trim( $link['description'] ) ) : ?>
							<p class="text-sm"><span class="opacity-65">Description:</span> <?= substr( htmlspecialchars( $link['description'] ), 0, 100) ?> <?= strlen($link['description']) > 100 ? '...' : ''?></p>
						<?php endif; ?>

						<?php if ( isset($link['board_name']) ) : ?>
							<span><span class="text-sm opacity-65">Board:</span> <span class="rounded-md text-sm bg-teal-600/15 p-1"><?= htmlspecialchars( $link['board_name'] ) ?></span></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>