<?php
session_start(); 
require_once "../model/review.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reservation = $_POST['id_reservation'];
    $note = $_POST['note'];
    $comment = $_POST['comment'];


    if (!isset($note) || $note < 1 || $note > 5) {
        $_SESSION['error'] = "Please enter a valid note number between 1 and 5.";
        header("Location: ../view/client_dashboard.php");
        exit;
    }

  
    if (!isset($comment) || empty($comment)) {
        $_SESSION['error'] = "Please enter a comment.";
        header("Location: ../view/client_dashboard.php");
        exit;
    }

    try {
        $review = new Review($id_reservation, $comment, $note);
        $review->addReview();
        $_SESSION['success'] = "Review added successfully!";
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    

    header("Location: ../view/client_dashboard.php");
    exit();
}
?>