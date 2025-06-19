<?php
namespace app\controllers\api;

use app\core\Controller;
use app\services\ReviewService;

class ReviewController extends Controller {
    private ReviewService $reviewService;

    public function __construct() {
        $this->reviewService = new ReviewService();
        header('Content-Type: application/json');
    }

    public function index() {
        $spaceId = $_GET['space_id'] ?? null;
        $reviews = $spaceId
            ? $this->reviewService->getSpaceReviews($spaceId)
            : $this->reviewService->getAllReviews();
        echo json_encode($reviews);
    }

    public function store() {
        $data = $_POST;

        $review = new \app\models\Review();
        $review->setUserId($_SESSION['user']->getId());
        $review->setSpaceId($data['space_id']);
        $review->setRating((int)$data['rating']);
        $review->setComment($data['comment']);

        $createdReview = $this->reviewService->createReview($review);
        echo json_encode($createdReview);
    }
}