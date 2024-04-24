<?php
class Database {
    // Specify your own db credentials
    private $host = 'localhost';
    private $db_name = 'banhang';
    private $username = 'root';
    private $password = '';

    public $conn;

    // Get the db connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=". $this->host.";dbname=".$this->db_name,
            $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Connection error : " . $exception->getMessage();
        }

        return $this->conn;
        
    }
}
?>