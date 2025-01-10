<?php
require_once 'conexion_db.php';

class Favorite {
    private $user_id;
    private $article_id;

    public function __construct($user_id, $article_id) {
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }

    public function addToFavorites() {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "INSERT INTO favorites (user_id, article_id) VALUES (:user_id, :article_id)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $stmt->bindParam(":article_id", $this->article_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("can't add to favorite" . $e->getMessage() );
            return false;
        }
    }
    
    public function removeFromFavorites() {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "DELETE FROM favorites WHERE user_id = :user_id AND article_id = :article_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $stmt->bindParam(":article_id", $this->article_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("can remove from favorite" . $e->getMessage());
            return false;
        }
    }

    public static function getUserFavorites($user_id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT article.* FROM article
                  JOIN favorites ON article.id_article = favorites.article_id
                  WHERE favorites.user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>