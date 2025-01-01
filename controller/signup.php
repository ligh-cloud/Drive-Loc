<?php 
require "../model/user.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['first-name'];
    $prenom = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = [];
    if (empty($password) || empty($confirmPassword)) {
        $errors[] = "Both password fields are required";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "The passwords don't match";
    }
    
  
    if (empty($nom) || empty($prenom)) {
        $errors[] = "Username is required";
    }
    
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if(empty($error)){
        $user = new user($name , $prenom , $email ,$password , "user" ) ;
        $user->register();
        header("location: ../view/login.php");
    }
}

?>