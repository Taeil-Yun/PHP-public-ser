<?php

class Member
{
    private $table_name = "ex_mem_info";  // table name

    // object properties
    public $mem_no;
    public $mem_id;
    public $mem_password;
    public $mem_last_name;
    public $mem_middle_name;
    public $mem_first_name;
    public $mem_nickname;
    public $mem_country_code;
    public $mem_phone;
    public $mem_recommend;
    public $mem_state;
    public $mem_register_dt;
    public $mem_leave_dt;
    public $mem_admin;


    // 회원 정보 조회
    function selectMem($database, $where = null, $limit = null, $join = null)
    {
        if ($result = $database->select($table = 'ex_mem_info', $rows = 'ex_mem_info.*, mem_bp,mem_lp,mem_cp ,mem_level,mem_exp', " ex_mem_point ON ex_mem_info.mem_no =ex_mem_point.mem_no
JOIN ex_mem_exp ON ex_mem_info.mem_no=ex_mem_exp.mem_no", $where, null, $limit)) {
            return $result;
        } else {
            return false;
        }
    }

    // 닉네임 중복조회
    function exist($database)
    {

        // 내 닉네임인지 확인 (닉네임에 변경사항이 없는지 확인)
//        $nick_ori = "";
        $my_nick = "mem_no='" . $this->mem_no . "'";
        $result = $database->select($table = "ex_mem_info", $rows = 'mem_nickname', $join = null, $where = $my_nick);
        if ($result) {
            // 내 원래 닉네임을 저장
            $nick_ori = $result[0]['mem_nickname'];
            // echo $nick_ori;
        } else {
            return false;
        }

        // 중복조회
        $exist_nick = "mem_nickname='" . $this->mem_nickname . "'";
        if ($result2 = $database->select($table = "ex_mem_info", $rows = 'count(*) as cnt', $join = null, $where = $exist_nick)) {
            // print_r($result2[1]['cnt']);
            $cnt = (int)$result2[1]['cnt']; // 중복확인 결과값
            if ($cnt == 0 || $this->mem_nickname == $nick_ori) { // 중복이 0이거나 내 아이디면 0을 출력
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function updateMem($database, $data)
    {
        if ($database->update('ex_mem_info', $data, "mem_no='" . $this->mem_no . "'")) {
            return true;
        } else {
            return false;
        }
    }

    // id exists function
    function idExists($database)
    {
        if ($count = $database->select($this->table_name, $rows = 'count(*)', null, $where = "mem_no='" . $this->mem_no . "'")) {
            return $count[0]['count(*)'];
        } else {
            return false;
        }
    }

    function login($database)
    {
        if ($result = $database->select($this->table_name, '*', null, $where = "mem_id='" . $this->mem_id . "'")) {
            $this->mem_no = $result[0]['mem_no'];
            $this->mem_password = $result[0]['mem_password'];
            $this->mem_admin = $result[0]['mem_admin'];
            return true;
        } else {
            return false;
        }
    }

}


?>
