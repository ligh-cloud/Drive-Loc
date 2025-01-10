<?php
session_start();
require "../model/theme.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_theme']) && isset($_POST['theme_name']) && !empty($_POST['theme_name'])) {
        $id = $_POST['id_theme'];
        $name = $_POST['theme_name'];
        if (Theme::editTheme($id, $name)) {
            $_SESSION['success'] = "Theme updated successfully";
        } else {
            $_SESSION['error'] = "Cannot update the theme";
        }
    } else {
        $_SESSION['error'] = "Invalid input data";
    }
}
header("Location: ../view/theme_article.php");
exit();
?>