<?php
require_once '../model/Tag.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $tag = new Tag($_POST['tag_name']);
                $tag->createTag();
                $_SESSION['success'] = 'Tag added successfully';
                break;
            
            case 'edit':
                $tag = new Tag($_POST['tag_name']);
                $tag->id_tag = $_POST['id_tag'];
                $tag->editTag();
                $_SESSION['success'] = 'Tag edited successfully';
                break;
            
            case 'delete':
                Tag::deleteTag($_POST['id_tag']);
                $_SESSION['success'] = 'Tag deleted successfully';
                break;
        }
    }
    header('Location: ../view/admin_dashboard.php');
    exit();
}
?>