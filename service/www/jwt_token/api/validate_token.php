<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to decode jwt
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// if you don't get jwt values from cookies ""
$cookie_jwt = isset($_COOKIE['JWT']) ? array("jwt"=>$_COOKIE['JWT']) : "";
$jwt =  json_encode($cookie_jwt);
$data = json_decode($jwt);

// import token
$jwt=isset($data->jwt) ? $data->jwt : "";

if($jwt) {
    try {  // display user details when decoding is successful
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        http_response_code(200);
        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        ));
    }
    // display error97 when decoding failed
    catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied.",
            "error97" => $e->getMessage()
        ));
        header("location: ../login_ok.php");
    }
    header("location: ../index.php");
} else {
    echo "<script>alert('Access denied');</script>";
    header("location: ../login_ok.php");
}