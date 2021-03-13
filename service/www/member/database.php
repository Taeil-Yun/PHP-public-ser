<?php
class Database {
    // DB info
    private $host = "YOUR HOST";
    private $db_name = "YOUR DATABASE";
    private $username = "YOUR USER NAME";
    private $password = "YOUR PASSWORD";
    private $port = "YOUR PORT";
    public $conn;

    // connect
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host:$this->port;dbname=". $this->db_name, $this->username, $this->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));  // insert encoding change
        } catch(PDOException $exception) {
            echo "Connection error97: " . $exception->getMessage();
        }
        return $this->conn;
    }
}