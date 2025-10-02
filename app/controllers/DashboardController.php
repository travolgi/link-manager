<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/BoardModel.php';
require_once __DIR__ . '/../models/LinkModel.php';

class DashboardController extends Controller {
	protected $boardModel;
	protected $linkModel;

	public function __construct($pdo) {
		parent::__construct($pdo);
		$this->boardModel = new BoardModel($pdo);
		$this->linkModel = new LinkModel($pdo);
	}

	public function showDashboard() {
		$this->requireLogin();

		$user_id = $this->currentUserId;

		$stats = [
			'total_boards' => $this->boardModel->getTotalBoardsByUser( $user_id ),
			'total_links' => $this->linkModel->getTotalLinksByUser( $user_id ),
			'avg_links' => $this->linkModel->getAvgLinksPerBoardByUser( $user_id ),
		];

		$recentLinks = $this->linkModel->getRecentLinksByUser( $user_id, 5 );

		$boards = $this->boardModel->getBoardsByUser( $user_id );

		$this->render('dashboard', [ 'stats' => $stats, 'recentLinks' => $recentLinks, 'boards' => $boards ]);
	}
}