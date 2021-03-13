<?php
class Database {
    // DB info
    private $host = "52.79.146.126";
    private $db_name = "user1";
    private $username = "user1";
    private $password = "back0010";
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