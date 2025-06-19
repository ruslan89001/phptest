<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Review;
use app\services\ReviewService;
use app\services\SpaceService;

class ReviewController extends Controller {
    private ReviewService $reviewService;
    private SpaceService $spaceService;

    public function __construct() {
        $this->reviewService = new ReviewService();
        $this->spaceService = new SpaceService();
    }

    public function index() {
        $spaces = $this->spaceService->getAvailableSpaces();
        $reviews = [];
        if (isset($_GET['space_id'])) {
            $reviews = $this->reviewService->getSpaceReviews($_GET['space_id']);
        }
        return $this->render('reviews/index', [
            'spaces' => $spaces,
            'reviews' => $reviews
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review = new Review();
            $review->setUserId($_SESSION['user']->getId());
            $review->setSpaceId($_POST['space_id']);
            $review->setRating($_POST['rating']);
            $review->setComment($_POST['comment']);

            $this->reviewService->createReview($review);
            $this->redirect('/reviews');
        }
    }
}