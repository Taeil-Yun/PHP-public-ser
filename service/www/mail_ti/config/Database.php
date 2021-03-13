<?php

class Database
{

    public $mysqli = null;

    private $list_array = array();

    public function __construct($host, $user)
    {
        $this->getConnection($host, $user);
    }

// getConnection
    public function getConnection($host, $user)
    {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/config/common_config.php";

        //host type
        if ($host == "READ") {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/config/read_config.php";

        } else if ($host == "WRITE") {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/config/write_config.php";
        } else {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "please check host type."));
        }

        //user
        $DB_USER = $user;
        $DB_PASS = $user . "_PW";

        //connect
        $this->mysqli = new mysqli(HOST, constant($DB_USER), constant($DB_PASS), DB_NAME, PORT);

        //error97
        if ($this->mysqli->connect_errno) {
            echo "Error MySQLi : (" & nbsp . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
            exit();
        }

        $this->mysqli->set_charset("utf8mb4");
    }

    // deconstructor
    public function __destruct()
    {
        $this->CloseDB();
    }

    // Close config connection
    public function CloseDB()
    {
        $this->mysqli->close();
    }

    // runs a sql query
    public function selectRunQuery($query)
    {

        $result = $this->mysqli->query($query);

        if (isset($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($this->list_array, $row);
            }
            $result = $this->list_array;
            return $result;
        } else {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "select query no result."));
        }
    }

    public function runQuery($query)
    {
        if ($result = $this->mysqli->query($query)) {
            return $result;
        } else {
            return false;
        }
    }

    //select query
    public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
    {
        if ($this->tableExists($table)) {
            $query = 'SELECT ' . $rows . ' FROM scoreclass.' . $table;
            if ($join != null) {
                $query .= ' JOIN ' . $join;
            }
            if ($where != null) {
                $query .= ' WHERE ' . $where;
            }
            if ($order != null) {
                $query .= ' ORDER BY ' . $order;
            }
            if ($limit != null) {
                $query .= ' LIMIT ' . $limit;
            }
            return $this->selectRunQuery($query);
        } else {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "SELECT : Table not exists."));
        }
    }

    //insert query
    public function insert($table, $params = array())
    {
        if ($this->tableExists($table)) {
            $query = 'INSERT INTO ' . $table . ' (' . implode(', ', array_keys($params)) . ') VALUES ("' . implode('", "', $params) . '")';
            return $this->runQuery($query);
        } else {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "INSERT : Table not exists."));
        }
    }

    //update query
    public function update($table, $params = array(), $where)
    {
        if ($this->tableExists($table)) {
            $values = "";
            for ($i = 0; $i < count($params); $i++) {
                $value = (array_values($params)[$i] != NULL) ? "'" . array_values($params)[$i] . "'" : 'NULL ';
                $values .= ($i == 0 || $i == count($params) ? '' : ',') . array_keys($params)[$i] . " = " . $value;
            }
            $query = 'UPDATE scoreclass.' . $table . ' SET ' . $values . " WHERE {$where}";
            return $this->runQuery($query);
        } else {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "UPDATE : Table not exists."));
        }
    }

    public function tableExists($table)
    {
        $tables = $this->runQuery('SHOW TABLES FROM ' . DB_NAME . ' LIKE "' . $table . '"');
        if ($tables) {
            if (mysqli_num_rows($tables) > 0) {
                return true;
            } else {
                http_response_code(500);
                return json_encode(array("state" => 500, "message" => "TableExists : Table not exists."));
            }
        } else {
            http_response_code(500);
            return json_encode(array("state" => 500, "message" => "TableExists : query error97."));
        }
    }

    public function clearText($text)
    {
        $text = trim($text);
        return $this->mysqli->real_escape_string($text);
    }
}

?>
