<?php
require_once 'conexion_db.php';

class Tag
{
    public $id_tag;
    public $tag_name;

    public function __construct($tag_name)
    {
        $this->tag_name = $tag_name;
    }

    public static function getTagByName($tag_name)
    {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tags WHERE tag_name = ?");
        $stmt->execute([$tag_name]);
        $tag = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tag) {
            $tag_obj = new Tag($tag['tag_name']);
            $tag_obj->id_tag = $tag['id_tag'];
            return $tag_obj;
        }
        return null;
    }

    public static function getAllTags()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM tags");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getArticlesByTag($tag_name)
    {
        $db = new Database();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("
            SELECT a.title, a.content, a.id_article, a.user_id, a.theme_id, a.image 
            FROM tags t
            JOIN articletags at ON t.id_tag = at.id_tag
            JOIN article a ON at.id_article = a.id_article
            WHERE t.tag_name LIKE :tagName
        ");
        $stmt->execute([':tagName' => '%' . $tag_name . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTag()
    {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("INSERT INTO tags (tag_name) VALUES (?)");
        $stmt->execute([$this->tag_name]);
        $this->id_tag = $conn->lastInsertId();
    }

    public function editTag()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE tags SET tag_name = :tag_name WHERE id_tag = :id_tag");
        $stmt->bindParam(":tag_name", $this->tag_name);
        $stmt->bindParam(":id_tag", $this->id_tag);
        $stmt->execute();
    }

    public static function deleteTag($id_tag)
    {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM tags WHERE id_tag = :id_tag");
        $stmt->bindParam(":id_tag", $id_tag);
        $stmt->execute();
    }
}
?>