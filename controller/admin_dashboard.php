<?php
require_once "../model/User.php";
require_once "../model/Car.php"; 

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    if($_SESSION['role'] == 'user'){
        header('Location: ../view/client_dashboard.php');
    }
    header('Location: ../view/login.php');
   
    exit();
}

$errorMessage = $_SESSION['error'] ?? null;
$successMessage = $_SESSION['success'] ?? null;
$dashboardStats = [
    'total_users' => 0,
    'total_cars' => 0,
    'active_reservations' => 0,
    'total_reviews' => 0
];
$users = [];
$cars = [];
$categories = [];

$admin = new Admin("", "", "", "", "admin");
$car = new Car("", "", "", "", "", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'archive_user':
                    if (isset($_POST['user_id'])) {
                        $admin->archiveUser($_POST['user_id']);
                        $successMessage = "User archived successfully";
                        $_SESSION['success'] = $successMessage;
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    }
                    break;
                    
                    case 'add_car':
                        if (isset($_POST['marque']) && isset($_POST['modele']) && 
                            isset($_POST['annee']) && isset($_POST['category']) && 
                            isset($_POST['price']) && isset($_FILES['image'])) {
                            
                            try {
                             
                                $uploadDir = '../uploads/cars/';
                                if (!file_exists($uploadDir)) {
                                    mkdir($uploadDir, 0777, true);
                                }
                    
                                $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                                $fileName = uniqid() . '.' . $fileExtension;
                                $uploadFile = $uploadDir . $fileName;
                    
                               
                                $allowedTypes = ['jpg', 'jpeg', 'png'];
                                if (!in_array(strtolower($fileExtension), $allowedTypes)) {
                                    throw new Exception("Invalid file type. Only JPG, JPEG, and PNG are allowed.");
                                }
                    
                               
                                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                                   
                                    $newCar = new Car(
                                        htmlspecialchars(trim($_POST['category'])),
                                        htmlspecialchars(trim($_POST['modele'])),
                                        floatval($_POST['price']),
                                        htmlspecialchars(trim($_POST['marque'])),
                                        intval($_POST['annee']),
                                        $fileName  
                                    );
                    
                               
                                    $carData = [
                                        'category' => $_POST['category'],
                                        'marque' => $_POST['marque'],
                                        'modele' => $_POST['modele'],
                                        'prix' => $_POST['price'],
                                        'place' => $_POST['places'] ?? 5, 
                                        'image' => $fileName
                                    ];
                    
                               
                                    if($newCar->addCar($carData)) {
                                        $successMessage = "Car added successfully";
                                        $_SESSION['success'] = $successMessage;
                                    } else {
                                        throw new Exception("Failed to add car");
                                    }
                                } else {
                                    throw new Exception("Failed to upload image");
                                }
                                
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit();
                            } catch (Exception $e) {
                                $_SESSION['error'] = $e->getMessage();
                                header('Location: ' . $_SERVER['PHP_SELF']);
                                exit();
                            }
                        } else {
                            $_SESSION['error'] = "All car fields are required";
                            header('Location: ' . $_SERVER['PHP_SELF']);
                            exit();
                        }
                        break;
                        case 'add_category':
                            if (isset($_POST['nom']) && isset($_POST['description'])) {
                                try {
                                    if ($admin->addCategory(
                                        htmlspecialchars(trim($_POST['nom'])), 
                                        htmlspecialchars(trim($_POST['description']))
                                    )) {
                                        $successMessage = "Category added successfully";
                                        $_SESSION['success'] = $successMessage;
                                    } else {
                                        throw new Exception("Failed to add category");
                                    }
                                    header('Location: ' . $_SERVER['PHP_SELF']);
                                    exit();
                                } catch (Exception $e) {
                                    $_SESSION['error'] = $e->getMessage();
                                    header('Location: ' . $_SERVER['PHP_SELF']);
                                    exit();
                                }
                            }
                            break;
                        
                        case 'delete_category':
                            if (isset($_POST['category_id'])) {
                                try {
                                    if ($admin->deleteCategory($_POST['category_id'])) {
                                        $successMessage = "Category deleted successfully";
                                        $_SESSION['success'] = $successMessage;
                                    } else {
                                        throw new Exception("Failed to delete category");
                                    }
                                    header('Location: ' . $_SERVER['PHP_SELF']);
                                    exit();
                                } catch (Exception $e) {
                                    $_SESSION['error'] = $e->getMessage();
                                    header('Location: ' . $_SERVER['PHP_SELF']);
                                    exit();
                                }
                            }
                            break;
            }
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        $_SESSION['error'] = $errorMessage;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}


try {

    $dashboardStats = $admin->getDashboardStats();
    $categories = $admin->getAllCategories();

    $users = $admin->getAllUsers();
    

    $cars = $car->getAllCars();
    
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    $_SESSION['error'] = $errorMessage;
}
$categories = $admin->getAllCategories();
    



unset($_SESSION['error'], $_SESSION['success']);

$currentDateTime = date('Y-m-d H:i:s');
$currentUser = $_SESSION['email'] ?? 'Unknown';

$dashboardStats = array_merge([
    'total_users' => 0,
    'total_cars' => 0,
    'active_reservations' => 0,
    'total_reviews' => 0
], $dashboardStats ?? []);

?>