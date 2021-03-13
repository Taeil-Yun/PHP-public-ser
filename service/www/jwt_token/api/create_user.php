<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// import data
$u_info = json_encode(['id'=>$_POST['id'], 'password'=>$_POST['password'], 'phone'=>$_POST['phone'], 'email'=>$_POST['email'], 'u_name'=>$_POST['u_name']]);
$data = json_decode($u_info);

// set property value
$user->id = $data->id;
$user->password = $data->password;
$user->phone = $data->phone;
$user->email = $data->email;
$user->u_name = $data->u_name;

// use create method and create user
if( !empty($user->id) &&
    !empty($user->password) &&
    !empty($user->phone) &&
    !empty($user->email) &&
    !empty($user->u_name) &&
    $user->create()
) {
    http_response_code(200);
    echo "<script>alert('User was created.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
} else {
    http_response_code(400);
    echo "<script>alert('ID, phone number, email already exists.'); history.back();</script>";
}