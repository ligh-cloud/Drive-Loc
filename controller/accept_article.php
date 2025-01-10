<?php
session_start();
require_once '../model/Article.php';

if (isset($_POST['article_id']) && !empty($_POST['article_id'])) {
    $articleId = intval($_POST['article_id']);

    if (Article::acceptArticle($articleId)) {
        $_SESSION['success_message'] = 'Article accepted successfully!';
    } else {
        $_SESSION['error_message'] = 'Error accepting the article. Please try again.';
    }
} else {
    $_SESSION['error_message'] = 'Invalid article ID.';
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>