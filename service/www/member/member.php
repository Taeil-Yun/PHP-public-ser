<?php
class User {
    private $conn;  // config connection
    private $table_name = "ex_mem_info";  // user info table

    public $mem_no;
    public $mem_id;
    public $mem_password;
    public $mem_nickname;
    public $mem_last_name;
    public $mem_middle_name;
    public $mem_first_name;
    public $mem_country_code;
    public $mem_phone;
    public $mem_recommend;
    public $mem_state;
    public $mem_register_dt;

    public function __construct($db) {
        $this->conn = $db;
    }

    function user_insert() {
        $query = "INSERT INTO ". $this->table_name ."
                SET
                    mem_no = :mem_no,
                    mem_id = :mem_id,
                    mem_password = :mem_password,
                    mem_nickname = :mem_nickname,
                    mem_last_name = :mem_last_name,
                    mem_middle_name = :mem_middle_name,
                    mem_first_name = :mem_first_name,
                    mem_country_code = :mem_country_code,
                    mem_phone = :mem_phone,
                    mem_recommend = :mem_recommend,
                    mem_state = :mem_state,
                    mem_register_dt = :mem_register_dt";

        // prepare the query
        $stmt = $this->conn->prepare($query) or die;

        $this->mem_no='';
        $this->mem_id=htmlspecialchars(strip_tags($this->mem_id));
        $this->mem_password=htmlspecialchars(strip_tags($this->mem_password));
        $this->mem_nickname=htmlspecialchars(strip_tags($this->mem_nickname));
        $this->mem_last_name=htmlspecialchars(strip_tags($this->mem_last_name));
        $this->mem_middle_name=htmlspecialchars(strip_tags($this->mem_middle_name));
        $this->mem_first_name=htmlspecialchars(strip_tags($this->mem_first_name));
        $this->mem_country_code=htmlspecialchars(strip_tags($this->mem_country_code));
        $this->mem_phone=htmlspecialchars(strip_tags($this->mem_phone));
        $this->mem_recommend=htmlspecialchars(strip_tags($this->mem_recommend));
        $this->mem_state = htmlspecialchars(strip_tags($this->mem_state));
        $this->mem_register_dt = time();

        // bind the values
        $stmt->bindParam(':mem_no', $this->mem_no);
        $stmt->bindParam(':mem_id', $this->mem_id);
        $stmt->bindParam(':mem_password', $this->mem_password);
        $stmt->bindParam(':mem_nickname', $this->mem_nickname);
        $stmt->bindParam(':mem_last_name', $this->mem_last_name);
        $stmt->bindParam(':mem_middle_name', $this->mem_middle_name);
        $stmt->bindParam(':mem_first_name', $this->mem_first_name);
        $stmt->bindParam(':mem_country_code', $this->mem_country_code);
        $stmt->bindParam(':mem_phone', $this->mem_phone);
        $stmt->bindParam(':mem_recommend', $this->mem_recommend);
        $stmt->bindParam(':mem_state', $this->mem_state);
        $stmt->bindParam(':mem_register_dt', $this->mem_register_dt);

        // execute the query, also check if query was successful
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // id exists function
    function idExists() {
        // query to check if id exists
        $query = "SELECT mem_no FROM ". $this->table_name ." WHERE mem_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->mem_id=htmlspecialchars(strip_tags($this->mem_id));
        $stmt->bindParam(1, $this->mem_id);
        $stmt->execute();
        $num = $stmt->rowCount();

        // enclose values in object properties to access and use sessions if ids are present
        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // assign values to object properties
            $this->mem_no = $row['mem_no'];
            return true;
        } else {
            return false;
        }
        return false;
    }

    function nicknameExists() {
        // query to check if id exists
        $query = "SELECT mem_id FROM ". $this->table_name ." WHERE mem_nickname = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->mem_nickname=htmlspecialchars(strip_tags($this->mem_nickname));
        $stmt->bindParam(1, $this->mem_nickname);
        $stmt->execute();
        $num = $stmt->rowCount();

        // enclose values in object properties to access and use sessions if ids are present
        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // assign values to object properties
            $this->mem_id = $row['mem_id'];
            return true;
        }
        return false;
    }

    function Select_memNo() {
        $query = "SELECT mem_no FROM ".$this->table_name."
                  WHERE mem_id = :mem_id 
                  and mem_nickname = :mem_nickname 
                  and mem_phone = :mem_phone";
        $stmt = $this->conn->prepare($query) or die;

        $this->mem_id = htmlspecialchars(strip_tags($this->mem_id));
        $this->mem_nickname = htmlspecialchars(strip_tags($this->mem_nickname));
        $this->mem_phone = htmlspecialchars(strip_tags($this->mem_phone));

        $stmt->bindParam(':mem_id', $this->mem_id);
        $stmt->bindParam(':mem_nickname', $this->mem_nickname);
        $stmt->bindParam(':mem_phone', $this->mem_phone);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->mem_no = $row['mem_no'];
            return true;
        } else {
            return false;
        }
    }

    function insert_exp_point($column_) {
        $query = "INSERT INTO ".$column_." SET mem_no = ?";
        // prepare the query
        $stmt = $this->conn->prepare($query) or die;

        $this->mem_no = htmlspecialchars(strip_tags($this->mem_no));
        $stmt->bindParam(1, $this->mem_no);
        // execute the query, also check if query was successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}