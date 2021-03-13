<?php
$path = $_SERVER["DOCUMENT_ROOT"];

include_once $path . "/config/Database.php";
include_once $path . "/objects/member/device.php";

$db_dvc_u = new Database('WRITE', 'MODIFY_DEVICE');

$device = new Device();

$device->dvc_id = $_COOKIE['did'];

if ($device->updateDvc($db_dvc_u, array("state" => 'n'))) {
    setcookie('did', '', time() - 86400, '/');
    echo "<script>location.href='/';</script>";
} else {
    echo "<script>alert('다시 시도해주세요.');</script>";
}
?>
