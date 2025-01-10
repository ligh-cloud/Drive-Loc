<?php
session_start();
require "../model/comments.php";

if (isset($_POST['submit'])) {
    if (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_POST['article_id']) && !empty($_POST['article_id'])) {
        $commentText = trim($_POST['comment']);
        $articleId = intval($_POST['article_id']);

        try {
         
            $comment = new comments($commentText, $articleId);
            $comment->addComment();
            $_SESSION['success_message'] = 'Comment added successfully!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error adding comment: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = 'Please provide both a comment and an article ID.';
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>