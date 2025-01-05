<?php
session_start();
require_once "../model/Reservation.php";




if (isset($_POST['reservation_id'])) {
    $reservationId = $_POST['reservation_id'];
    $reservation = new Reservation($_SESSION['user_id']);
    try {
        $reservation->updateReservationStatus($reservationId, 'terminee');
        $_SESSION["success"] = "confirmation successful";
        header("location: ../view/view_reservation.php");
    } catch (Exception $e) {
        $_SESSION["error"] = "error to confirm " . $e->getMessage();
        header("location: ../view/view_reservation.php");
    }
} else {
    header('Location: ../view/view_reservations.php');
    exit();
}