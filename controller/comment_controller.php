<?php
require_once '../model/comments.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
        

            case 'edit':
                $comment = new Comments($_POST['comment'], $_POST['id_article']);
                $comment->id_commentaire = $_POST['id_commentaire'];
                $comment->editComment();
                $_SESSION['success'] = 'Comment edited successfully';
                break;

            case 'delete':
                Comments::deleteComment($_POST['id_commentaire']);
                $_SESSION['success'] = 'Comment deleted successfully';
                break;
        }
    }
    header('Location: ../view/admin_dashboard.php');
    exit();
}
?>