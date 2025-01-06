<?php 
session_start();
require "../model/theme.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    if (isset($_POST['theme_name']) && !empty($_POST['theme_name'])) {
        $name = $_POST['theme_name'];
        $theme = new Theme($name); 
        if ($theme->createTheme()) { 
            $_SESSION['success'] = "Theme added successfully";
            header("location: ../view/theme_article.php");
            exit(); 
        } else {
            $_SESSION['error'] = "Cannot add the theme";
        }
    } else {
        $_SESSION['error'] = "Theme name cannot be empty";
    }
}
header("location: ../view/theme_article.php");                          
exit();
?>