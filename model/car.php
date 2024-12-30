<?php 

abstract class Vehicle {
    protected $id;
    protected $category;
    protected $modele;
    protected $prix;
    protected $disponibiliter;
    protected $image;

    abstract public function getDetails();
    abstract public function calculateRentalCost($days);


}

// User.php
// Car.php
class Car extends Vehicle {
    public function __construct($category, $modele, $prix, $disponibiliter, $image) {
        $this->category = $category;
        $this->modele = $modele;
        $this->prix = $prix;
        $this->disponibiliter = $disponibiliter;
        $this->image = $image;
    }

    public function getDetails() {
        // Implementation to get car details
    }

    public function calculateRentalCost($days) {
        return $this->prix * $days;
    }

    public function makeReservation($user, $date_start, $date_end) {
        // Implementation to make a reservation
    }

    public function cancelReservation($reservation_id) {
        // Implementation to cancel a reservation
    }

    public function addCar() {
        // Implementation to add a car
    }

    public function updateCar() {
        // Implementation to update car details
    }

    public function deleteCar() {
        // Implementation to delete a car
    }

    public function filterCars($category) {
        // Implementation to filter cars by category
    }
}
?>