<?php
$path = $_SERVER["DOCUMENT_ROOT"];

//include
include_once $path . "/config/Database.php";
include_once $path . "/objects/member/member.php";
include_once $path . "/objects/member/device.php";

//config & objects
//member
$db_mem_s = new Database('READ', 'READ_MEMBER');
$member = new Member();
//device
$db_dvc_s = new Database('READ', 'READ_DEVICE');
$db_dvc_u = new Database('WRITE', 'MODIFY_DEVICE');
$db_dvc_i = new Database('WRITE', 'WRITE_DEVICE');
$device = new Device();

$data = json_decode(file_get_contents('php://input'), true);

$member->mem_id = $data['mem_id'];

if ($member->login($db_mem_s)) {
//id Exist : O
    if ($member->mem_password == $data['mem_password']) {
        //password : O
        if ($member->mem_admin == 1) {
            //admin : O
            $device->mem_no = $member->mem_no;

            if ($device->dvcExists($db_dvc_s, "mem_no='" . $member->mem_no . "'")) {
                //dvc_id Exist : O
                if ($device->updateDvc($db_dvc_u, array("update_dt" => time(), "dvc_ip" => $_SERVER["REMOTE_ADDR"], "state" => 'y'))) {
                    //Update : O
                    setcookie('did', $device->dvc_id, time() + 86400, '/');
                    echo json_encode(array("state" => 200, "message" => "Login success."));
                } else {
                    //Update : X
                    echo json_encode(array("state" => 500, "message" => "Update Dev : Login error97."));
                }

            } else {
                //dvc_id Exist : X
                if ($device->insertDvc($db_dvc_i)) {
                    //Insert : O
                    setcookie('did', $device->dvc_id, time() + 86400, '/');
                    echo json_encode(array("state" => 200, "message" => "Login success."));
                } else {
                    //Insert : X
                    echo json_encode(array("state" => 500, "message" => "Insert Dev : Login error97."));
                }
            }

        } else {
            //admin : X
            echo json_encode(array("state" => 403, "message" => "Forbidden."));
        }
    } else {
        //password : X
        echo json_encode(array("state" => 400, "message" => "Login fail."));
    }
} else {
//id Exist : X
    echo json_encode(array("state" => 500, "message" => "Login error97."));
}

?>