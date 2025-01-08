<?php
require_once 'conexion_db.php';

class Tag {
    public $id;
    public $tag_name;

    public function __construct($tag_name) {
        $this->tag_name = $tag_name;
    }

    public static function getTagByName($tag_name) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tags WHERE tag_name = ?");
        $stmt->execute([$tag_name]);
        $tag = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tag) {
            $tag_obj = new Tag($tag['tag_name']);
            $tag_obj->id = $tag['id_tag'];
            return $tag_obj;
        }
        return null;
    }

    public function createTag() {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("INSERT INTO tags (tag_name) VALUES (?)");
        $stmt->execute([$this->tag_name]);
        $this->id = $conn->lastInsertId();
    }
}
?>