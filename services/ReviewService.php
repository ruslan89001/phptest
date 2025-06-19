<?php
namespace app\services;

use app\mappers\ReviewMapper;
use app\models\Review;

class ReviewService {
    private ReviewMapper $mapper;

    public function __construct() {
        $this->mapper = new ReviewMapper();
    }

    public function getAllReviews(): array {
        return $this->mapper->findAll();
    }

    public function getSpaceReviews(int $spaceId): array {
        return $this->mapper->findBySpace($spaceId);
    }

    public function createReview(Review $review): Review {
        $reviewId = $this->mapper->save($review);
        return $this->mapper->findById($reviewId);
    }
}