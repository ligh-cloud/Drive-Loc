<?php 

class Database {
    private $host = "localhost";
    private $dbname = "location";  
    private $username = "root";    
    private $password = "";       
    private $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            return $this->conn;
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
            die();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}



?>