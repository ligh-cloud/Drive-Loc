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
            $query = "INSERT INTO theme (name) VALUES (:name)";
            $stm = $conn->prepare($query);
            $stm->bindParam(":name", $this->name);
            $stm->execute();
            return true; 
        } catch (PDOException $e) {
            throw new Exception("Error theme: " . $e->getMessage());
            return false; 
        }
    }
static function deleteTheme($id_theme){
    try{
    $db = new Database();
        $conn = $db->getConnection();
    $query = "DELETE FROM theme WHERE id_theme = :id_theme";
    $stm = $conn->prepare($query);
    $stm->bindParam(":id_theme" , $id_theme);
    $stm->execute();
    }
    catch(PDOException $e){
        throw new Exception("error changing the name of the theme" . $e->getMessage());
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



}

?>