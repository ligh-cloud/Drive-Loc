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
                        if (isset($_POST['marque']) && isset($_POST['modele']) && isset($_POST['categorie_id'])) {
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
                                    $carData = [
                                        'categorie_id' => intval($_POST['categorie_id']), 
                                        'marque' => htmlspecialchars(trim($_POST['marque'])),
                                        'modele' => htmlspecialchars(trim($_POST['modele'])),
                                        'prix' => floatval($_POST['price']),
                                        'place' => isset($_POST['places']) ? intval($_POST['places']) : 5,
                                        'image' => $fileName
                                    ];
                    
                                    
                                    $newCar = new Car(
                                        $carData['categorie_id'],
                                        $carData['modele'],
                                        $carData['prix'],
                                        $carData['marque'],
                                        intval($_POST['annee']),
                                        $fileName
                                    );
                    
                               
                                    if($newCar->addCar($carData)) {
                                        $_SESSION['success'] = "Car added successfully";
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
                        case 'add_multiple_cars':
                            if (isset($_POST['cars']) && is_array($_POST['cars'])) {
                                try {
                                    $uploadDir = '../uploads/cars/';
                                    if (!file_exists($uploadDir)) {
                                        mkdir($uploadDir, 0777, true);
                                    }
                        
                                    $successCount = 0;
                                    $errors = [];
                        
                                    foreach ($_POST['cars'] as $index => $carData) {
                                        try {
                                          
                                            if (empty($carData['marque']) || empty($carData['modele']) || 
                                                empty($carData['categorie_id']) || empty($carData['price'])) {
                                                throw new Exception("Missing required fields for car #" . ($index + 1));
                                            }
                        
                                            
                                            $fileKey = "cars_{$index}_image";
                                            if (!isset($_FILES['cars']['name'][$index]['image'])) {
                                                throw new Exception("No image provided for car #" . ($index + 1));
                                            }
                        
                                            $file = $_FILES['cars']['tmp_name'][$index]['image'];
                                            $fileName = uniqid() . '_' . basename($_FILES['cars']['name'][$index]['image']);
                                            $uploadFile = $uploadDir . $fileName;
                        
                                            
                                            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                            $allowedTypes = ['jpg', 'jpeg', 'png'];
                                            if (!in_array($fileExtension, $allowedTypes)) {
                                                throw new Exception("Invalid file type for car #" . ($index + 1));
                                            }
                        
                                            if (move_uploaded_file($file, $uploadFile)) {
                                                $newCar = new Car(
                                                    intval($carData['categorie_id']),
                                                    htmlspecialchars(trim($carData['modele'])),
                                                    floatval($carData['price']),
                                                    htmlspecialchars(trim($carData['marque'])),
                                                    intval($carData['annee']),
                                                    $fileName
                                                );
                        
                                                $carDataForDb = [
                                                    'categorie_id' => intval($carData['categorie_id']),
                                                    'marque' => $carData['marque'],
                                                    'modele' => $carData['modele'],
                                                    'prix' => $carData['price'],
                                                    'place' => $carData['places'] ?? 5,
                                                    'image' => $fileName
                                                ];
                        
                                                if ($newCar->addCar($carDataForDb)) {
                                                    $successCount++;
                                                } else {
                                                    throw new Exception("Failed to add car #" . ($index + 1));
                                                }
                                            } else {
                                                throw new Exception("Failed to upload image for car #" . ($index + 1));
                                            }
                                        } catch (Exception $e) {
                                            $errors[] = $e->getMessage();
                                        }
                                    }
                        
                                    if ($successCount > 0) {
                                        $_SESSION['success'] = "Successfully added $successCount cars.";
                                    }
                                    if (!empty($errors)) {
                                        $_SESSION['error'] = "Some cars could not be added: " . implode(", ", $errors);
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