<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/config/Database.php";
include_once $path . "/objects/member/device.php";
include_once $path . "/objects/member/member.php";

$db_dvc_s = new Database('READ', 'READ_DEVICE');
$db_mem_s = new Database('READ', 'READ_MEMBER');

$device = new Device();
$member = new Member();

//did로 로그인한 회원의 회원번호 검색
if ($device->dvcExists($db_dvc_s, "dvc_id='" . $_COOKIE['did'] . "'")) {
    if ($result = $member->selectMem($db_mem_s, "ex_mem_info.mem_no=" . $device->mem_no)) {
        echo json_encode(array("state" => 200, "message" => (array("id" => $result[0]['mem_id'], "nickname" => $result[0]['mem_nickname']))));
    } else {
        echo json_encode(array("state" => 500, "message" => "Not Found User."));
    }
} else {
    echo json_encode(array("state" => 500, "message" => "Device Id Search Error."));
}


?>