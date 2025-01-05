<?php
require_once "conexion_db.php";

class Review {
    private $id;
    private $id_reservation;
    private $comment;
    private $rating;
    private $archive;

    public function __construct($id_reservation, $comment, $rating) {
        $this->id_reservation = $id_reservation;
        $this->comment = $comment;
        $this->rating = $rating;
        $this->archive = 'false';
    }
    
    public function showReview($user_id){
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT avis.id_avis, avis.note, avis.commentaire, avis.created_at, reservations.id AS reservation_id, 
                cars.marque, cars.modele 
                FROM avis 
                JOIN reservations ON avis.id_reservation = reservations.id 
                JOIN cars ON reservations.id_car = cars.id_car 
                WHERE reservations.id_user = :user_id AND avis.archive_avis = 'false'";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReview() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "INSERT INTO avis (note, commentaire, id_reservation) VALUES (:note, :comment, :id_reservation)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":note", $this->rating);
            $stmt->bindParam(":comment", $this->comment);
            $stmt->bindParam(":id_reservation", $this->id_reservation);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Review error: " . $e->getMessage());
        }
    }

    public function softDeleteReview($review_id) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "UPDATE avis SET archive_avis = 'true' WHERE id_avis = :id_avis";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_avis', $review_id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Soft delete error: " . $e->getMessage());
        }
    }
}
?>