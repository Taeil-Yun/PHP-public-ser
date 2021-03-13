<?php
class User {
    private $conn;  // config connection
    private $table_name = "new_table1";  // table name

    public $id;
    public $password;
    public $phone;
    public $email;
    public $u_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO ". $this->table_name ."
                SET
                    id = :id,
                    password = :password,
                    phone = :phone,
                    email = :email,
                    u_name = :u_name";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->u_name=htmlspecialchars(strip_tags($this->u_name));

        // bind the values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':u_name', $this->u_name);

        // hash the password before saving to config
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        // execute the query, also check if query was successful
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // id exists function
    function idExists() {
        // query to check if id exists
        $query = "SELECT password, phone, email, u_name FROM ". $this->table_name ." WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $num = $stmt->rowCount();

        // enclose values in object properties to access and use sessions if ids are present
        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // assign values to object properties
            $this->password = $row['password'];
            $this->phone = $row['phone'];
            $this->email = $row['email'];
            $this->u_name = $row['u_name'];
            return true;
        }
        return false;
    }

//    // user info update
//    public function update(){
//      // password update case
//      $password_set=!empty($this->password) ? ", password = :password" : "";
//
//      // 입력된 암호가 없으면 암호를 업데이트 X
//      $query = "UPDATE ". $this->table_name ." SET phone = :phone, name = :name, email = :email {$password_set} WHERE id = :id";
//      $stmt = $this->conn->prepare($query);
//      $this->phone=htmlspecialchars(strip_tags($this->phone));
//      $this->name=htmlspecialchars(strip_tags($this->name));
//      $this->email=htmlspecialchars(strip_tags($this->email));
//
//      $stmt->bindParam(':phone', $this->phone);
//      $stmt->bindParam(':name', $this->name);
//      $stmt->bindParam(':email', $this->email);
//
//      // password hash encrypt
//      if(!empty($this->password)){
//          $this->password=htmlspecialchars(strip_tags($this->password));
//          $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
//          $stmt->bindParam(':password', $password_hash);
//      }
//
//      // unique ID of record to be edited
//      $stmt->bindParam(':id', $this->id);
//
//      // execute the query
//      if($stmt->execute()) {
//          return true;
//      }
//      return false;
//    }
  }