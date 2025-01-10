<?php 
require_once "conexion_db.php";

class Theme {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }
    public function createTheme() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "INSERT INTO theme (name) VALUES (:name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error creating theme: " . $e->getMessage());
        }
    }

static function showAllthemes(){
    try{
        $db = new Database;
        $conn = $db->getConnection();
        $query = "SELECT *FROM theme ";
        $stm = $conn->prepare($query);
        $stm->execute();
        return $stm->fetchall(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        throw new Exception("error showing all the themes " . $e->getMessage());
    }
}
public static function filterByTheme($tagName) {
    try {
       
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT t.name, a.title, a.id_article, a.content, a.image 
                  FROM theme t 
                  INNER JOIN article a ON t.id_theme = a.theme_id 
                  WHERE t.name = :tagName";
        
     
        $stmt = $conn->prepare($query);
   
        $stmt->bindParam(':tagName', $tagName, PDO::PARAM_STR);
 
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        
    }
}


public static function getAllThemes() {
    $db = new Database();
    $conn = $db->getConnection();
    $query = "SELECT * FROM theme";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function deleteTheme($id) {
    try {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "DELETE FROM theme WHERE id_theme = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error deleting theme: " . $e->getMessage());
    }
}

public static function editTheme($id, $name) {
    try {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "UPDATE theme SET name = :name WHERE id_theme = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error editing theme: " . $e->getMessage());
    }
}



}

?>