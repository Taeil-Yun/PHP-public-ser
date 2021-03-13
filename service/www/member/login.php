<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "./database.php";
include_once "./member.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->mem_id = $data->mem_id;
$user->mem_password = $data->mem_password;
$user->mem_nickname = $data->mem_nickname;
$id_exists = $user->idExists();

if(!empty($user->mem_id) && !empty($user->mem_password)) {
    session_start();
    if ($id_exists && $data->mem_password == $user->mem_password) {
        http_response_code(200);
        $_SESSION['mem_id'] = $user->mem_id;
        $_SESSION['mem_nickname'] =$user->mem_nickname;
        echo json_encode(["message"=>"Login Success"]);
    } else {
        http_response_code(400);
        echo "fail";
    }
} else {
    echo "failed";
}