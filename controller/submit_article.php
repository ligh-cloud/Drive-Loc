<?php
session_start();
require "../model/article.php";
require "../model/tag.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token.";
        header('Location: ../view/add_article.php');
        exit();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../view/login.php');
        exit();
    }

  
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $user_id = $_SESSION['user_id'];
    $theme_id = intval($_POST['theme_id']);
    $tags_input = htmlspecialchars(trim($_POST['tags']));


    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/';
        $image = $upload_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types) && $_FILES['image']['size'] <= 5000000) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                $_SESSION['error'] = "Failed to upload image.";
                header('Location: ../view/add_article.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid image file type or size.";
            header('Location: ../view/add_article.php');
            exit();
        }
    }

    $video = null;
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $video = $upload_dir . basename($_FILES['video']['name']);
        $videoFileType = strtolower(pathinfo($video, PATHINFO_EXTENSION));
        $allowed_types = ['mp4', 'avi', 'mov', 'wmv'];
        if (in_array($videoFileType, $allowed_types) && $_FILES['video']['size'] <= 50000000) {
            if (!move_uploaded_file($_FILES['video']['tmp_name'], $video)) {
                $_SESSION['error'] = "Failed to upload video.";
                header('Location: ../view/add_article.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid video file type or size.";
            header('Location: ../view/add_article.php');
            exit();
        }
    }

   
    $article = new Article($title, $content, $image, $video, $user_id, $theme_id);
    try {
        $conn = new Database();
        $conn->getConnection()->beginTransaction();

        $article_id = $article->createArticle();

  
        $tags = array_unique(array_filter(array_map('trim', explode(',', $tags_input))));
        foreach ($tags as $tag_name) {
            $tag = Tag::getTagByName($tag_name);
            if (!$tag) {
                $tag = new Tag($tag_name);
                $tag->createTag();
            }
            $tag_id = $tag->id;
            $article->addTag($article_id, $tag_id);
        }

        $conn->getConnection()->commit(); 
        $_SESSION['success'] = "article created successfully";
    } catch (Exception $e) {
        $conn->getConnection()->rollBack();
        $_SESSION['error'] = $e->getMessage();
    }

    header('Location: ../view/add_article.php');
    exit();
}
?>