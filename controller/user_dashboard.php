<?php 

require_once "../model/User.php";

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../view/login.php');
    exit();
}
$user = new user

?>