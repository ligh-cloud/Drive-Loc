<?php 
require "conexion_db.php";

class comments{
    private $comment;

    private $id_article;

    function __construct($comment, $id_article)
    {
        $this->comment = $comment;
        $this->id_article = $id_article;
    }
    function addComment(){
        $db = new Database;
        $conn = $db->getConnection();
        try {
        $conn->beginTransaction();
        $query = "INSERT INTO commentaire(commentaire) VALUE (:commentaire)";
        $stm = $conn->prepare($query);
        $stm->bindParam(":commentaire" , $this->comment);
        $stm->execute();

        $id_commentaire = $conn->lastInsertId();
        $sql = "INSERT INTO commentairearticle(id_commentaire , id_article) VALUES (:id_commentaire , :id_article)";
        $stm1 = $conn->prepare($sql);
        $stm1->bindParam(":id_commentaire" , $id_commentaire);
        $stm1->bindParam(":id_article" , $this->id_article);
        $stm1->execute();
        $conn->commit();


    }
    catch(PDOException $e){
        throw new Exception("Can't add the comment" . $e->getMessage());
    }
}

}

?>