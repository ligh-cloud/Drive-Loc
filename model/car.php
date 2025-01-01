<?php 

abstract class Vehicle {
    protected $id;
    protected $category;
    protected $modele;
    protected $prix;
    protected $disponibiliter;
    protected $image;

    abstract public function getDetails();
    


}


class Car extends Vehicle {
    private $marque;
    private $annee;

    public function __construct($category, $modele, $prix, $marque, $annee, $image) {
        $this->category = $category;
        $this->modele = $modele;
        $this->prix = $prix;
        $this->marque = $marque;
        $this->annee = $annee;
        $this->image = $image;
    }

    public function getDetails() {
        return [
            'category' => $this->category,
            'modele' => $this->modele,
            'prix' => $this->prix,
            'marque' => $this->marque,
            'annee' => $this->annee,
            'image' => $this->image
        ];
    }

    public function addCar($carData) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "INSERT INTO cars (category, modele,marque , prix, places, image) 
                   VALUES (:category, :modele,:marque, :prix, :place, :image)";
            
            $stmt = $conn->prepare($sql);
            return $stmt->execute($carData);
        }
        catch(PDOException $e) {
            throw new Exception("Error adding car: " . $e->getMessage());
        }
    }

    public function getAllCars() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT * FROM cars";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Error getting cars: " . $e->getMessage());
        }
    }

    // Other methods remain the same...


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