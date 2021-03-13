<?php

class Device
{
    private $table_name = "ex_dvc_login";

    // object properties
    public $dvc_id;
    public $mem_no;
    public $insert_dt;
    public $update_dt;
    public $dvc_ip;
    public $state;

    //select dvc_id
    function dvcExists($database, $where)
    {
        if ($result = $database->select($this->table_name, '*', null, $where)) {
            $count = count($result);
            if ($count > 0) {
                $this->dvc_id = $result[0]['dvc_id'];
                $this->mem_no = $result[0]['mem_no'];
                $this->insert_dt = $result[0]['insert_dt'];
                $this->update_dt = $result[0]['update_dt'];
                $this->state = $result[0]['state'];
                $this->dvc_ip = $result[0]['dvc_ip'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //update data(login:update_dt, state, dvc_ip // logout:state)
    function updateDvc($database, $params)
    {
        if ($database->update($this->table_name, $params, "dvc_id='" . $this->dvc_id . "'")) {
            return true;
        } else {
            return false;
        }
    }

    //insert
    function insertDvc($database)
    {
        $random = random_int(1111, 9999);
        $params = array("dvc_id" => $random, "mem_no" => $this->mem_no, "insert_dt" => time(), "dvc_ip" => $_SERVER["REMOTE_ADDR"], "state" => 'y');
        if ($database->insert($this->table_name, $params)) {
            $this->dvc_id = $random;
            return true;
        } else {
            return false;
        }
    }


}


?>