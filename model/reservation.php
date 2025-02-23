<?php 

require "conexion_db.php";
class Reservation {
    private $userId;
    private $carId;
    private $dateDebut;
    private $dateFin;
    private $statut;

    public function __construct($userId) {
        $this->userId = $userId;
        $this->statut = 'en_cours';
    }

    public function getRecentReservations($limit = 5) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT r.*, c.modele,  u.nom, u.prenom 
                   FROM reservations r
                   JOIN cars c ON r.id_car = c.id_car
                   JOIN users u ON r.id_user = u.id
                   ORDER BY r.date_debut DESC
                   LIMIT :limit";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            throw new Exception("Error fetching recent reservations: " . $e->getMessage());
        }
    }

    public function makeReservation($carId, $dateDebut, $dateFin, $prixtotal) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $conn->beginTransaction();
  
            if (!is_numeric($carId) || !is_numeric($prixtotal)) {
                throw new Exception("Invalid car ID or price format");
            }
            
          
            
            $sql = "INSERT INTO reservations (id_user, id_car, date_debut, date_fin, statut, prix_total)
                    VALUES (:userId, :carId, :dateDebut, :dateFin, :statut, :prix)";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':userId' => $this->userId,
                ':carId' => $carId,
                ':dateDebut' => $dateDebut,
                ':dateFin' => $dateFin,
                ':statut' => $this->statut,
                ':prix' => $prixtotal
            ]);
            
            if (!$result) {
                throw new Exception("Failed to insert reservation");
            }
            
       
            $conn->commit();
            return true;
            
        } catch (PDOException $e) {
           
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            throw new Exception("Reservation error: " . $e->getMessage());
        } catch (Exception $e) {
            
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            throw $e;
        }
    }
    

    // private function isCarAvailable($carId, $dateDebut, $dateFin) {
    //     try {
    //         $db = new Database();
    //         $conn = $db->getConnection();
            
    //         $sql = "SELECT COUNT(*) FROM reservations 
    //                WHERE id_car = :carId 
    //                AND statut = 'en_cours'
    //                AND ((date_debut BETWEEN :dateDebut AND :dateFin) 
    //                OR (date_fin BETWEEN :dateDebut AND :dateFin))";
            
    //         $stmt = $conn->prepare($sql);
    //         $stmt->execute([
    //             ':carId' => $carId,
    //             ':dateDebut' => $dateDebut,
    //             ':dateFin' => $dateFin
    //         ]);
            
    //         return $stmt->fetchColumn() == 0;
    //     }
    //     catch(PDOException $e) {
    //         throw new Exception("Error checking availability: " . $e->getMessage());
    //     }
    // }

    public function getUserReservations($userId) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT r.*, c.modele, c.marque
                   FROM reservations r
                   JOIN cars c ON r.id_car = c.id_car
                   WHERE r.id_user = :userId
                   ORDER BY r.date_debut DESC";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            throw new Exception("Error fetching reservations: " . $e->getMessage());
        }
    }

 
    public function getReservationDetails($reservationId) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT r.*, c.modele, c.category, u.nom, u.prenom 
                   FROM reservations r
                   JOIN cars c ON r.id_car = c.id_car
                   JOIN users u ON r.id_user = u.id
                   WHERE r.id = :reservationId";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([':reservationId' => $reservationId]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            throw new Exception("Error fetching reservation details: " . $e->getMessage());
        }
    }

   
    public function updateReservationStatus($reservationId, $newStatus) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "UPDATE reservations 
                   SET statut = :status 
                   WHERE id = :reservationId";
            
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':status' => $newStatus,
                ':reservationId' => $reservationId
            ]);
        }
        catch(PDOException $e) {
            throw new Exception("Error updating reservation status: " . $e->getMessage());
        }
    }
}
?>