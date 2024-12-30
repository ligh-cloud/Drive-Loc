<?php 
// review.php
class Review {
    private $id;
    private $id_user;
    private $id_car;
    private $comment;
    private $rating;
    private $archive;

    public function __construct($id_user, $id_car, $comment, $rating) {
        $this->id_user = $id_user;
        $this->id_car = $id_car;
        $this->comment = $comment;
        $this->rating = $rating;
        $this->archive = 'false';
    }

    public function addReview() {
        // implementation to add a review
    }

    public function updateReview() {
        // implementation to update a review
    }

    public function deleteReview() {
        // implementation to delete a review
    }

    public function softDeleteReview() {
        // implementation to soft delete a review
    }
}
?>