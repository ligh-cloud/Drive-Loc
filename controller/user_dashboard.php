<?php 
require_once "../model/user.php";
require_once "../model/car.php";
require_once "../model/reservation.php";


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../view/login.php');
    exit();
}

$errorMessage = $_SESSION['error'] ?? null;
$successMessage = $_SESSION['success'] ?? null; 
$selectedCar = null;
$cars = [];
$categories = [];


$user = [
    'id' => $_SESSION['user_id'],
    'email' => $_SESSION['email'],
    'nom' => $_SESSION['nom'],
    'prenom' => $_SESSION['prenom']
];

try {
   
    $carObj = new Car("", "", "", "", "", "");
    $categoryObj = new Admin("", "", "", "", "");
    $reservationObj = new Reservation($user['id']);


    $categories = $categoryObj->getAllCategories();


    $categoryFilter = $_GET['category'] ?? null;
    $maxPriceFilter = $_GET['max_price'] ?? null;


    $cars = $carObj->getAvailableCars($categoryFilter, $maxPriceFilter);

    
    if (isset($_GET['car_id'])) {
        $selectedCar = $carObj->getCarById($_GET['car_id']);
        if (!$selectedCar) {
            throw new Exception("Car not found");
        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'make_reservation':
                if (isset($_POST['car_id']) && isset($_POST['date_debut']) && 
                    isset($_POST['date_fin']) && isset($_POST['car_price'])) {
                    
              
                    $dateDebut = new DateTime($_POST['date_debut']);
                    $dateFin = new DateTime($_POST['date_fin']);
                    
                    if ($dateFin <= $dateDebut) {
                        throw new Exception("End date must be after start date");
                    }

                    $interval = $dateDebut->diff($dateFin);
                    $numberOfDays = $interval->days + 1;
                    $totalPrice = $numberOfDays * floatval($_POST['car_price']);

                    
                    if ($reservationObj->makeReservation(
                        $_POST['car_id'],
                        $_POST['date_debut'],
                        $_POST['date_fin'],
                        $totalPrice
                    )) {
                        $_SESSION['success'] = "Reservation made successfully";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        throw new Exception("Failed to make reservation");
                    }
                } else {
                    throw new Exception("Missing required reservation information");
                }
                break;
        }
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    $_SESSION['error'] = $errorMessage;
}


unset($_SESSION['error'], $_SESSION['success']);
?>