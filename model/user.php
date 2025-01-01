<?php 
require_once "conexion_db.php";

class User {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $role;
    protected $archive;

    public function __construct($nom, $prenom, $email, $password) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = 'user'; 
        $this->archive = 'false';
    }

    public function register() {
        $conn = null;
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $conn->beginTransaction();

            $checkEmail = "SELECT email FROM users WHERE email = :email";
            $checkStmt = $conn->prepare($checkEmail);
            $checkStmt->bindParam(":email", $this->email);
            $checkStmt->execute();
            
            if($checkStmt->rowCount() > 0) {
                throw new Exception("Email already exists");
            }

            $sql = "INSERT INTO users (nom, prenom, email, password, archive) 
                   VALUES (:nom, :prenom, :email, :password, :archive)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nom", $this->nom);
            $stmt->bindParam(":prenom", $this->prenom);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":archive", $this->archive);
            
            if($stmt->execute()) {
                $userId = $conn->lastInsertId();
                if($userId == 1){
                    $this->role = 'admin';
                }
                $roleSql = "INSERT INTO role (id_user, role) VALUES (:userId, :role)";
                $roleStmt = $conn->prepare($roleSql);
                $roleStmt->bindParam(":userId", $userId);
                $roleStmt->bindParam(":role", $this->role);
                
                if($roleStmt->execute()) {
                    $conn->commit();
                    return $userId;
                }
            }
            
            $conn->rollBack();
            return false;
        }
        catch(PDOException $e) {
            if($conn !== null) {
                $conn->rollBack();
            }
            throw new Exception("Registration error: " . $e->getMessage());
        }
    }

    public function login($email, $password) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT u.*, r.role FROM users u 
                   LEFT JOIN role r ON u.id = r.id_user 
                   WHERE u.email = :email AND u.archive = 'false'";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                return true;
            }
            return false;
        }
        catch(PDOException $e) {
            throw new Exception("Login error: " . $e->getMessage());
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        return true;
    }

    public function updateProfile($userId, $data) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $updateFields = [];
            $params = [];
            
            foreach($data as $key => $value) {
                if(in_array($key, ['nom', 'prenom', 'email'])) {
                    $updateFields[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }
            
            if(!empty($updateFields)) {
                $sql = "UPDATE users SET " . implode(", ", $updateFields) . 
                       " WHERE id = :id AND archive = 'false'";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $userId);
                
                foreach($params as $key => &$value) {
                    $stmt->bindParam($key, $value);
                }
                
                return $stmt->execute();
            }
            return false;
        }
        catch(PDOException $e) {
            throw new Exception("Update error: " . $e->getMessage());
        }
    }
}

class Admin extends User {
    public function __construct($nom, $prenom, $email, $password, $role) {
        parent::__construct($nom, $prenom, $email, $password, $role);
        $this->role = 'admin';
    }

    public function getAllUsers() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT u.*, r.role FROM users u 
                   LEFT JOIN role r ON u.id = r.id_user 
                   WHERE u.archive = 'false'";
            
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            throw new Exception("Error fetching users: " . $e->getMessage());
        }
    }

    public function getDashboardStats() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $stats = [
                'total_users' => $conn->query("SELECT COUNT(*) FROM users WHERE archive = 'false'")->fetchColumn(),
                'total_cars' => $conn->query("SELECT COUNT(*) FROM cars")->fetchColumn(),
                'active_reservations' => $conn->query("SELECT COUNT(*) FROM reservations WHERE statut = 'en_cours'")->fetchColumn(),
                'total_reviews' => $conn->query("SELECT COUNT(*) FROM avis WHERE archive_avis = 'false'")->fetchColumn()
            ];
            
            return $stats;
        }
        catch(PDOException $e) {
            throw new Exception("Error fetching stats: " . $e->getMessage());
        }
    }

    

    public function manageReservation($reservationId, $action) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "UPDATE reservations SET statut = :status WHERE id = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':status' => $action,
                ':id' => $reservationId
            ]);
        }
        catch(PDOException $e) {
            throw new Exception("Error managing reservation: " . $e->getMessage());
        }
    }

    public function archiveUser($userId) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "UPDATE users SET archive = 'true' WHERE id = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([':id' => $userId]);
        }
        catch(PDOException $e) {
            throw new Exception("Error archiving user: " . $e->getMessage());
        }
    }
    public function getAllCategories() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "SELECT * FROM categories ORDER BY nom";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching categories: " . $e->getMessage());
        }
    }
    
    public function addCategory($nom, $description) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "INSERT INTO categories (nom, description) VALUES (:nom, :description)";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'nom' => $nom,
                'description' => $description
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error adding category: " . $e->getMessage());
        }
    }
    
    public function deleteCategory($id) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $sql = "DELETE FROM categories WHERE id = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Error deleting category: " . $e->getMessage());
        }
    }
}
?>