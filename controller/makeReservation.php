<?php
session_start();
require_once "../model/Reservation.php";


try {
   
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Please login to make a reservation');
    }

  
    if (!isset($_POST['car_id']) || !isset($_POST['date_debut']) || !isset($_POST['date_fin'])) {
        throw new Exception('Missing required fields');
    }

   
    $car_id = filter_var($_POST['car_id'], FILTER_VALIDATE_INT);
    $date_debut = filter_var($_POST['date_debut'], FILTER_SANITIZE_STRING);
    $date_fin = filter_var($_POST['date_fin'], FILTER_SANITIZE_STRING);

    $start_date = new DateTime($date_debut);
    $end_date = new DateTime($date_fin);
    $current_date = new DateTime();
    $interval = $start_date->diff($end_date);
    $number_of_days = $interval->days;
    $prix = htmlspecialchars($_POST['car_price']);
    $totalPrice = $prix * $number_of_days;

   
    if (!$car_id) {
        throw new Exception('Invalid car ID');
    }

   
    

    if ($start_date < $current_date) {
        throw new Exception('Start date cannot be in the past');
    }

    if ($end_date <= $start_date) {
        throw new Exception('End date must be after start date');
    }

   
    $reservation = new Reservation($_SESSION['user_id']);

    if ($reservation->makeReservation($car_id, $date_debut, $date_fin, $totalPrice)) {
        $_SESSION['success_message'] = 'Reservation created successfully';
    } else {
        throw new Exception('Failed to create reservation');
    }

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
}


header('Location: ../view/client_dashboard.php');
exit;
?>