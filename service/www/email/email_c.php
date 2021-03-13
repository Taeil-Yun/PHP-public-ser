<?php
$length = 8;
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters_length = strlen($characters);
$random_string = '';
for ($i = 0; $i < $length; $i++) {
    $random_string .= $characters[rand(0, $characters_length)];
}
$hash = hash('sha256', $random_string);

$host = "Input Host";
$user_id = "Input User";
$db_p = "Input Password";
$conn = mysqli_connect($host, $user_id, $db_p, "Input Database", "Input Port");
if(!$conn) { echo "Unable to connect to DB: " . mysqli_error($conn); exit; }
mysqli_query($conn,"INSERT INTO `member` VALUES ('country', 'id', 'pwd', 'nick', '{$_POST['email_']}', 'phone', 'family_name', '', 'last_name', '{$hash}', '')");
mysqli_close($conn);

$message = 'Thanks for signing up!'."<br>";
$message .= 'Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.'."<br><br>";
$message .= 'Please click this link to activate your account: '."<br>";
$message .= '<a href="http://YourIp/email/email_k.php?email='.$_POST['email_'].'&hash='.$hash.'">http://YourIp/email/email_k.php?email='.$_POST['email_'].'&hash='.$hash.'</a>';
if(isset($_POST['email_'])) {
    $to = $_POST['email_'];  // 입력한 이메일로 메일 발송
    echo $to;
    $subject = "이메일인증";  // 입력한 제목글
    $from = "dev@naver.com";

    $headers[] = "From: ".$from;  // 메일이 발송되었을때 보낸사람이 보여지는 부분
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    mail($to, $subject, $message, implode("\r\n", $headers));
}