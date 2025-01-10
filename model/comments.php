<?php
require_once 'conexion_db.php';

class Comments {
    private $comment;
    public $id_commentaire;
    private $id_article;


    public function __construct($comment, $id_article) {
        $this->comment = $comment;
        $this->id_article = $id_article;
    }

    
    public function addComment() {
        $db = new Database();
        $conn = $db->getConnection();
        
        try {
            $conn->beginTransaction();


            $query = "INSERT INTO commentaire(commentaire) VALUES (:commentaire)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":commentaire", $this->comment);
            $stmt->execute();


            $id_commentaire = $conn->lastInsertId();

            
            $sql = "INSERT INTO commentairearticle(id_commentaire, id_article) VALUES (:id_commentaire, :id_article)";
            $stmt1 = $conn->prepare($sql);
            $stmt1->bindParam(":id_commentaire", $id_commentaire);
            $stmt1->bindParam(":id_article", $this->id_article);
            $stmt1->execute();

            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Can't add the comment: " . $e->getMessage());
        }
    }

    public static function getAllComments() {
        $db = new Database();
        $conn = $db->getConnection();
    
        $stmt = $conn->prepare("
            SELECT c.id_commentaire, c.commentaire, ca.id_article 
            FROM commentaire c
            JOIN commentaireArticle ca ON c.id_commentaire = ca.id_commentaire
        ");
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editComment() {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE commentaire SET commentaire = :commentaire WHERE id_commentaire = :id_commentaire");
        $stmt->bindParam(":commentaire", $this->comment);
        $stmt->bindParam(":id_commentaire", $this->id_commentaire);
        $stmt->execute();
    }


    public static function deleteComment($id_commentaire) {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");
        $stmt->bindParam(":id_commentaire", $id_commentaire);
        $stmt->execute();
    }
}
?>