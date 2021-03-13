<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// DB connection --> confirm that the ID exists
include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// get login ID
$login_info = json_encode(['id'=>$_POST['id'], 'password'=>$_POST['password']]);
$data = json_decode($login_info);
// set product property values
$user->id = $data->id;
$id_exists = $user->idExists();

// generate json web token
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// confirm user password this is the same as get password
if ($id_exists && password_verify($data->password, $user->password)) {
//    $headers = json_encode(['typ'=>'JWT', 'alg'=>'HS256']);
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $user->id,
            "phone" => $user->phone,
            "email" => $user->email,
            "name" => $user->u_name
        )
    );
//    $token = json_encode(["iss" => $iss, "aud" => $aud, "iat" => $iat, "nbf" => $nbf, "data" => array("id" => $user->id, "phone" => $user->phone, "email" => $user->email, "name" => $user->u_name)]);
//    $jwt = base64_encode($headers) . "." . base64_encode($token) . "." . base64_encode($key);
    http_response_code(200);
    $jwt = JWT::encode($token, $key);  // create token and save cookie

    setcookie("JWT", $jwt, 0, "/");
    setcookie("name", $user->u_name, 0, "/");
    header("location: ./validate_token.php");
} else {
    http_response_code(401);
    echo '<script>alert("You`ve entered a wrong ID or password."); history.back();</script>';
}
?>