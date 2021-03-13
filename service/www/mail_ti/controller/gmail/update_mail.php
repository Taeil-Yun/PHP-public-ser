<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/config/Database.php";
require_once $path . "/objects/gmail/gmail.php";

$db = new Database('WRITE', 'MODIFY_MAIL');
$mail = new Gmail();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {

    $where = (count($data['gmno']) > 1) ? implode(',', $data['gmno']) : $data['gmno'];

    $where = "gm_idx IN (" . $where . ")";

    unset($data['gmno']);

    if ($mail->updateData($db, $data, $where)) {
        echo json_encode(array("state" => 200, "message" => "Update Success."));
    } else {
        echo json_encode(array("state" => 500, "message" => "Update fail."));
    }
} else {
    echo json_encode(array("state" => 400, "message" => "Not found data"));
}


?>