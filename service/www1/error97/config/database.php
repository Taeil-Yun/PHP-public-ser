<?php
class my_database {
    private $host = "HOST";
    private $db_name = "USER ID";
    private $user_name = "PASSWORD";
    private $db_password = "DATABASE";
    private $ports = "PORT";
    public $conn;

    public function connections() {
        $this->conn = null;
        $this->conn = new mysqli($this->host, $this->user_name, $this->db_password, $this->db_name, $this->ports);
        $this->conn->set_charset("utf8");

        if($this->conn->connect_error) {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "Connect Error: ".$this->conn->connect_error));
//            die('Connect Error:('.$this->conn->connect_error.') '.$this->conn->connect_error);
        }
        return $this->conn;
    }
}