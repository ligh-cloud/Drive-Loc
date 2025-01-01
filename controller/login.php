
<?php 
include "../model/user.php";
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        $_SESSION['error'] = "Tous les champs sont obligatoires";
        header("Location: ../view/login.php");
        exit();
    } 
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format d'email invalide";
        header("Location: ../view/login.php");
        exit();
    } 
    else {
        $user = new User("", "", $email, $password);
        
        if($user->login($email, $password)) {
            if($_SESSION['role'] === 'admin') {
                header("location: ../../view/admin_dashboard.php");
            } else {
                header("location: ../../view/client_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            header("Location: ../view/login.php");
            exit();
        }
    }
}
?>


<?php if(isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
    </div>
<?php endif; ?>