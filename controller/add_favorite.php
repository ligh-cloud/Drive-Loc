<?php
session_start();
require_once '../model/Favorite.php';

if (isset($_POST['add_favorite'])) {
    if (isset($_POST['article_id']) && !empty($_POST['article_id'])) {
        $articleId = intval($_POST['article_id']);
        $userId = $_SESSION['user_id']; 

        try {
            $favorite = new Favorite($userId, $articleId);
            $favorite->addToFavorites();
            $_SESSION['success_message'] = 'Article added to favorites!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error adding to favorites: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = 'Invalid article ID.';
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

if (isset($_POST['remove_favorite'])) {
    if (isset($_POST['article_id']) && !empty($_POST['article_id'])) {
        $articleId = intval($_POST['article_id']);
        $userId = $_SESSION['user_id']; 

        try {
            $favorite = new Favorite($userId, $articleId);
            $favorite->removeFromFavorites();
            $_SESSION['success_message'] = 'Article removed from favorites!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error removing from favorites: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = 'Invalid article ID.';
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>