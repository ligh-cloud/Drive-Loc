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


}

?>