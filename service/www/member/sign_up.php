<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "./database.php";
include_once "./member.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

// set property value
$user->mem_id = $data->mem_id;
$user->mem_password = $data->mem_password;
$user->mem_nickname = $data->mem_nickname;
$user->mem_last_name = $data->mem_last_name;
$user->mem_middle_name = $data->mem_middle_name;
$user->mem_first_name = $data->mem_first_name;
$user->mem_country_code = $data->mem_country_code;
$user->mem_phone = $data->mem_phone;
$nick_exists = $user->nicknameExists();

// use create method and create user
if($user->user_insert()) {
    if($nick_exists) {
        http_response_code(400);
        echo json_encode(["state"=>400, "message"=>"Sign - up is a Failed"]);
    } else {
        if ($user->Select_memNo()) {
            //point, exp insert success
            if ($user->insert_exp_point("ex_mem_point") && $user->insert_exp_point("ex_mem_exp")) {
                $database->conn->commit(); // transaction save
                http_response_code(200);
                echo json_encode(["state" => 200, "message" => "Sing - up Success"]);
                //insert failed
            } else {
                $database->conn->rollback(); // rollback
                http_response_code(500);
                echo json_encode(["state" => 500, "message" => "insert Point & Exp error97."]);
            }
            //exists user -> error97
        } else {
            http_response_code(500);
            echo json_encode(["state" => 500, "message" => "sign - up error97, user is a exists & not found member nooooooooo."]);
        }
    }
} else {
    http_response_code(400);
    echo json_encode(["state"=>400, "message"=>"Sign - up is a Failed"]);
}