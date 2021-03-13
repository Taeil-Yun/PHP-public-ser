<?php
class Users {
    private $conn;  // config connection
    private $table_name = "err_mem_info";  // user info table

    public $err_idx;
    public $err_mem_id;
    public $err_mem_password;
    public $err_mem_name;
    public $err_mem_birth;
    public $err_mem_sex;
    public $err_mem_email;
    public $err_mem_date;
    public $err_mem_state;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function d_insert() {
        $query = "INSERT INTO ". $this->table_name ." VALUES (default, ?, ?, ?, ?, ?, ?, ?, 0)";
//        SET
//                    err_mem_idx = :err_mem_idx,
//                    err_mem_id = :err_mem_id,
//                    err_mem_password = :err_mem_password,
//                    err_mem_name = :err_mem_name,
//                    err_mem_birth = :err_mem_birth,
//                    err_mem_sex = :err_mem_sex,
//                    err_mem_email = :err_mem_email,
//                    err_mem_date = :err_mem_date,
//                    err_mem_state = :err_mem_state

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $this->err_idx = '';
        $this->err_mem_id = htmlspecialchars(strip_tags($this->err_mem_id));
        $this->err_mem_password = htmlspecialchars(strip_tags($this->err_mem_password));
        $this->err_mem_name = htmlspecialchars(strip_tags($this->err_mem_name));
        $this->err_mem_birth = htmlspecialchars(strip_tags($this->err_mem_birth));
        $this->err_mem_sex = htmlspecialchars(strip_tags($this->err_mem_sex));
        $this->err_mem_email = htmlspecialchars(strip_tags($this->err_mem_email));
        $this->err_mem_date = time();
        $this->err_mem_state = 0;

        // bind the values
        $stmt->bind_param('sssssss', $this->err_mem_id, $this->err_mem_password, $this->err_mem_name,
            $this->err_mem_birth,
            $this->err_mem_sex, $this->err_mem_email, $this->err_mem_date);
//        $stmt->bind_param(':err_idx', $this->err_idx);
//        $stmt->bind_param(':err_mem_id', $this->err_mem_id);
//        $stmt->bind_param(':err_mem_password', $this->err_mem_password);
//        $stmt->bind_param(':err_mem_name', $this->err_mem_name);
//        $stmt->bind_param(':err_mem_birth', $this->err_mem_birth);
//        $stmt->bind_param(':err_mem_sex', $this->err_mem_sex);
//        $stmt->bind_param(':err_mem_email', $this->err_mem_email);
//        $stmt->bind_param(':err_mem_date', $this->err_mem_date);
//        $stmt->bind_param(':err_mem_state', $this->err_mem_state);

        // execute the query, also check if query was successful
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}