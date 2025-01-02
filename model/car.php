<?php 

abstract class Vehicle {
    protected $id;
    protected $categorie_id;
    protected $modele;
    protected $prix;
    protected $disponibiliter;
    protected $image;

    abstract public function getDetails();
    


}


class Car extends Vehicle {
    private $marque;
    private $annee;

    public function __construct($categorie_id, $modele, $prix, $marque, $annee, $image) {
        $this->categorie_id = $categorie_id;
        $this->modele = $modele;
        $this->prix = $prix;
        $this->marque = $marque;
        $this->annee = $annee;
        $this->image = $image;
    }

    public function getDetails() {
        return [
            'categorie_id' => $this->categorie_id,
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
            
            $sql = "INSERT INTO cars (categorie_id, modele, marque, prix, places, image) 
                   VALUES (:categorie_id, :modele, :marque, :prix, :place, :image)";
            
            $stmt = $conn->prepare($sql);
            
       
            $params = [
                ':categorie_id' => $carData['categorie_id'],
                ':modele' => $carData['modele'],
                ':marque' => $carData['marque'],
                ':prix' => $carData['prix'],
                ':place' => $carData['place'],
                ':image' => $carData['image']
            ];
            
            return $stmt->execute($params);
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
    public function getAvailableCars($categoryId = null, $maxPrice = null) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT c.*, cat.nom as category_name 
                    FROM cars c 
                    LEFT JOIN categories cat ON c.categorie_id = cat.id 
                    WHERE c.disponibilite = true";
            $params = [];
            
            if ($categoryId) {
                $sql .= " AND c.categorie_id = :category_id";
                $params['category_id'] = $categoryId;
            }
            
            if ($maxPrice) {
                $sql .= " AND c.prix <= :max_price";
                $params['max_price'] = $maxPrice;
            }
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching cars: " . $e->getMessage());
        }
    }
    
    public function getCarById($carId) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT c.*, cat.nom as category_name 
                    FROM cars c 
                    LEFT JOIN categories cat ON c.categorie_id = cat.id 
                    WHERE c.id_car = :car_id";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute(['car_id' => $carId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching car: " . $e->getMessage());
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