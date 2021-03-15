<?php
class Database {
    // DB info
    private $host = "HOST";
    private $db_name = "DATABASE";
    private $username = "USER";
    private $password = "PASSWORD";
    public $conn;

    // connect
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=". $this->host .";dbname=". $this->db_name, $this->username, $this->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));  // insert encoding change
        } catch(PDOException $exception) {
            echo "Connection error97: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
