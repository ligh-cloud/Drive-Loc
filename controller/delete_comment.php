<?php 
session_start(); 

require_once "../model/review.php";   

if (!isset($_SESSION['user_id'])) {     
    echo "User not logged in";     
    exit(); 
}  

if (!isset($_GET['id_avis'])) {     
    echo "Comment ID not provided";     
    exit(); 
}  

$comment_id = $_GET['id_avis'];  

try {     
    $review = new Review(null, null, null);     
   $review->softDeleteReview($comment_id);    
        header('Content-Type: application/json');         
        echo json_encode(['status' => 'success']);     
    
} catch (Exception $e) {     
    header('Content-Type: application/json');     
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]); 
} 
?>