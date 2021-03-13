<?php

$path = $_SERVER["DOCUMENT_ROOT"];

//include
include_once $path . "/config/Database.php";
include_once $path . "/objects/member/device.php";

//config & objects
$db_dvc_s = new Database('READ', 'READ_DEVICE');
$device = new Device();

//dvc_id : O
if ($device->dvcExists($db_dvc_s, "dvc_id='" . $_COOKIE['did'] . "'")) {

    //login ip == my ip
    if ($device->dvc_ip == $_SERVER['REMOTE_ADDR']) {
        return true;

        //login ip != my ip
    } else {
        echo json_encode(array("state" => 409, "message" => "error97 : Duplicate."));
        setcookie('did', '', time() - 86400, '/');
        exit;
    }

    //dvc_id : X
} else {
    echo json_encode(array("state" => 401, "message" => "error97 : Login Please."));
    setcookie('did', '', time() - 86400, '/');
    exit;
}


?>