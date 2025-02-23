<?php
require "conexion_db.php";

class Article {
    private $title;
    private $content;
    private $image;
    private $video;
    private $id_user;
    private $id_theme;

    function __construct($title, $content, $image, $video, $id_user, $id_theme) {
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->video = $video;
        $this->id_user = $id_user;
        $this->id_theme = $id_theme;
    }

    function createArticle() {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "INSERT INTO article (title, content, image, video, user_id, theme_id) VALUES (:title, :content, :image, :video, :user_id, :theme_id)";
            $stm = $conn->prepare($sql);
            $stm->execute([
                ':title' => $this->title,
                ':content' => $this->content,
                ':image' => $this->image,
                ':video' => $this->video,
                ':user_id' => $this->id_user,
                ':theme_id' => $this->id_theme
            ]);
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error creating article: " . $e->getMessage());
        }
    }

    static function getAllArticles() {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "SELECT * FROM article WHERE statut = 'accepter' ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    static function getAllArticlesAdmin() {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "SELECT * FROM article ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getArticleById($id) {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "SELECT * FROM article WHERE id_article = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTag($article_id, $tag_id) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("INSERT INTO acrticletags (id_article, id_tag) VALUES (?, ?)");
        $stmt->execute([$article_id, $tag_id]);
    }
    public static function searchByName($articleName) {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            $query = "SELECT * FROM article WHERE title LIKE :articleName";
            $stmt = $conn->prepare($query);
            $searchTerm = "%" . $articleName . "%";
            $stmt->bindParam(':articleName', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public static function acceptArticle($article_id) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE article SET statut = 'accepter' WHERE id_article = :article_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function deleteArticle($id_article){
        $db = new Database();
        $conn = $db->getConnection();
        $query = "DELETE FROM article WHERE id_article = :id_article";  
        $stm = $conn->prepare($query);
        $stm->bindParam(":id_article", $id_article);
        $stm->execute();
    }
}
?>