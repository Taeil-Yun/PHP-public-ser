<?php
error_reporting(E_ALL); ini_set("display_errors", 1);

header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../config/table_info.php";

$database = new my_database();
$db = $database->connections();
$user = new Users($db);

$user_info = json_encode(['id'=>$_POST['id'], 'password'=>$_POST['password'], 'name'=>$_POST['name'],
    'birth'=>$_POST['birth'].'-'.$_POST['month'].'-'.$_POST['day'], 'sex'=>$_POST['sex'], 'email'=>$_POST['email']
        .$_POST['b_email']]);
$data = json_decode($user_info);

// set property value
$user->err_mem_id = $data->id;
$user->err_mem_password = $data->password;
$user->err_mem_name = $data->name;
$user->err_mem_birth = $data->birth;
$user->err_mem_sex = $data->sex;
$user->err_mem_email = $data->email;

// use create method and create user
if($user->d_insert()) {
    http_response_code(200);
    echo json_encode(["state"=>200, "message"=>"Sign - up Success"]);
} else {
    http_response_code(400);
    echo json_encode(["state"=>400, "message"=>"Sign - up is a Failed"]);
}