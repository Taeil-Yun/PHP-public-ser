<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once 'config/database.php';
include_once 'objects/user.php';

// config connection
$database = new Database();
$db = $database->getConnection();

// user object --> instance
$user = new User($db);

// take over save data
$id = $_POST['id'];
$password = $_POST['password'];
$u_name = $_POST['u_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
//$dataa = '{"id":"' . $id . '","password":"' . $password . '","u_name":"' . $u_name . '","phone":"' . $phone . '","email":"' . $email . '","jwt":"' . $_COOKIE['jwt'] . '"}';
$dataa = json_encode(['id'=>$id, 'password'=>$password, 'u_name'=>$u_name, 'phone'=>$phone, 'email'=>$email, 'jwt'=>$_COOKIE['jwt']]);
$data = json_decode($dataa);

// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
if($jwt) {
    try {  // display user details if decoding is successful
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $user->id = $data->id;
        $user->password = $data->password;
        $user->phone = $data->phone;
        $user->email = $data->email;
        $user->u_name = $data->u_name;

        if($user->update()) {
            // jwt re-creation
            // user 정보가 변경된 경우 user 세부 정보가 다를 수 있으므로 새 JSON 웹 토큰을 다시 생성
            $token = array(
                "iss" => $iss,
                "aud" => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "data" => array(
                    "id" => $user->id,
                    "phone" => $user->phone,
                    "email" => $user->email,
                    "u_name" => $user->u_name
                )
            );
            $jwt = JWT::encode($token, $key);
            http_response_code(200);
            echo json_encode(
                array(
                    "message" => "User was updated.",
                    "jwt" => $jwt
                )
            );
        } else {  // user update failed
            http_response_code(401);
            echo json_encode(array("message" => "Unable to update user."));
        }
    }
    // 디코딩이 실패시 jwt 유효하지 않음
    catch(Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied.",
            "error97" => $e->getMessage()
        ));
    }
} else {  // jwt --> ""
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));  // tell the user access denied
}