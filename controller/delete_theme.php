<?php
session_start();
require "../model/theme.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_theme']) && !empty($_POST['id_theme'])) {
        $id = $_POST['id_theme'];
        if (Theme::deleteTheme($id)) {
            $_SESSION['success'] = "Theme deleted successfully";
        } else {
            $_SESSION['error'] = "Cannot delete the theme";
        }
    } else {
        $_SESSION['error'] = "Invalid theme ID";
    }
}
header("Location: ../view/theme_article.php");
exit();
?>