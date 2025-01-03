<?php 
require "conexion_db.php";
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
    public function getAvailableCars($categoryId = null, $maxPrice = null, $page = 1, $perPage = 6) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
     
            $baseQuery = "FROM cars c 
                         LEFT JOIN categories cat ON c.categorie_id = cat.id 
                         WHERE c.disponibilite = true";
            $params = [];
            
            if ($categoryId) {
                $baseQuery .= " AND c.categorie_id = :category_id";
                $params['category_id'] = $categoryId;
            }
            
            if ($maxPrice) {
                $baseQuery .= " AND c.prix <= :max_price";
                $params['max_price'] = $maxPrice;
            }
            
            $countQuery = "SELECT COUNT(*) as total " . $baseQuery;
            $countStmt = $conn->prepare($countQuery);
            $countStmt->execute($params);
            $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
           
            $offset = ($page - 1) * $perPage;
            $dataQuery = "SELECT c.*, cat.nom as category_name " . $baseQuery . 
                        " LIMIT :limit OFFSET :offset";
            
            $params['limit'] = $perPage;
            $params['offset'] = $offset;
            
            $dataStmt = $conn->prepare($dataQuery);
            $dataStmt->execute($params);
            $cars = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'cars' => $cars,
                'total' => $totalCount,
                'pages' => ceil($totalCount / $perPage)
            ];
            
        } catch (PDOException $e) {
            throw new Exception("Error fetching cars: " . $e->getMessage());
        }
    }
    
public function deleteCar($carId) {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "DELETE FROM cars WHERE id_car = :car_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':car_id', $carId);
        return $stmt->execute();
    } catch(PDOException $e) {
        throw new Exception("Error deleting car: " . $e->getMessage());
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


    public function filterCars($category) {
        // Implementation to filter cars by category
    }
}
?>