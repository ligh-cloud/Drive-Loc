<?php
session_start();
require_once "../model/review.php";

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $review = new Review(null, null, null); 
    $comments = $review->showReview($user_id); 

    foreach ($comments as $comment) {
        echo "<div class='p-4 border rounded-lg bg-gray-100'>";
        echo "<p><strong>Car:</strong> " . htmlspecialchars($comment['marque']) . " " . htmlspecialchars($comment['modele']) . "</p>";
        echo "<p><strong>Note:</strong> " . htmlspecialchars($comment['note']) . "</p>";
        echo "<p><strong>Comment:</strong> " . htmlspecialchars($comment['commentaire']) . "</p>";
        echo "<p><strong>Date:</strong> " . htmlspecialchars($comment['created_at']) . "</p>";
        echo "<button onclick='deleteComment(" . htmlspecialchars($comment['id_avis']) . ")' class='bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg mt-2'>Delete</button>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>