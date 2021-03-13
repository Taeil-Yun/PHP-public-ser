<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$phone = "";

//if($method == "GET") {
//    // 1. 자바스크립트 객체 또는 serialize() 로 전달
//    $phone = $_GET['phone'];
//    $get_arr = array("mode" => $_REQUEST['mode'], "phone" => $phone);
//    echo(json_encode($get_arr));
//}
if($method == "POST") {
    // 1. 자바스크립트 객체 또는 serialize() 로 전달
    $phone = $_POST['phone'];
    $post_arr = array("mode" => $_REQUEST['mode'], "phone" => $phone);
    echo(json_encode($post_arr));
}

/**********************************************************************/
/*                      휴대폰인증 SMS 발송                           */
/**********************************************************************/
$_tel = json_encode($post_arr['phone']); // 발송될 번호
$_tel = str_replace("-", "", $_tel);
$_msg = rand(1000,9999); // 메시지 내용
/**********************************DB***********************************/
$db_host = "HOST";
$db_username = "USER ID";
$db_password = "PASSWORD";
$db_name = "DATABASE";
$db_port = "PORT";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port);
mysqli_set_charset($conn, "utf8");
if(!$conn) { echo "Unable to connect to DB: " . mysqli_error($conn); exit; }
$sql = "INSERT INTO `phone_auth` VALUES ('', '{$_tel}', '{$_msg}', '')";
mysqli_query($conn, $sql);
mysqli_close($conn);
/***********************************DB************************************/
$url = "https://api.twilio.com/2010-04-01/Accounts/INPUT YOUR twilio KEY/Messages.json";
// url 변경금지

$from = "+123456789";  // 발송번호 ( 변경금지 / 고정됨 )
$to = "+82" . $_tel; // ( 편집가능 / 국제발신 / 예 : +821090595426 )
$body = "Code (" . $_msg . ")"; // ( 편집가능 )

$id = "YOUR twilio ID"; // (변경금지)
$token = "YOUR twilio TOKEN"; // (변경 금지)

//아래 내용 변경 금지.
$data = array(
    'From' => $from,
    'To' => $to,
    'Body' => $body,
);

$post = http_build_query($data);
$x = curl_init($url);
curl_setopt($x, CURLOPT_POST, true);
curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($x, CURLOPT_POSTFIELDS, $post);
curl_exec($x);
curl_close($x);

//$con = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE", "PORT") or die(mysqli_error($con));
//
//$tel_search = mysqli_query($con, "SELECT mem_key, hash, ck FROM `phone_auth` WHERE mem_key='{$_tel}' AND hash='{$_msg}' AND ck='0'") or die(mysqli_error($con));
//$tel_match  = mysqli_num_rows($tel_search);
//
//if($tel_match > 0) {
//    mysqli_query($con, "UPDATE `phone_auth` SET ck='1' WHERE mem_key='".$_tel."' AND hash='".$_msg."' AND ck='0'") or die(mysqli_error($con));
//    mysqli_close($con);
//    include_once './js/phone_check_ok.php';
//} else {
//    mysqli_close($con);
//    include_once './js/phone_check_fail.php';
//}