<?php 

class Reservation {
    private $id;
    private $id_user;
    private $id_car;
    private $date_reservation;

    public function __construct($id_user, $id_car, $date_reservation) {
        $this->id_user = $id_user;
        $this->id_car = $id_car;
        $this->date_reservation = $date_reservation;
    }

    public function makeReservation() {
        // implementation to make a reservation
    }

    public function cancelReservation() {
        // implementation to cancel a reservation
    }

    public function updateReservation() {
        // implementation to update a reservation
    }
}

?>