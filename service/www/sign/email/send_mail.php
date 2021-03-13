<?php
$length = 8;
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters_length = strlen($characters);
$random_string = '';
for($i=0; $i<$length; $i++) {
    $random_string .= $characters[rand(0, $characters_length)];
}
$hash = hash('sha256', $random_string);

$message = 'Thanks for signing up!'."<br>";
$message .= 'Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.'."<br><br>";
$message .= 'Please click this link to activate your account: '."<br>";
$message .= '<a href="http://YourIP/sign/email/email_ck.php?email='.$user_info['E-mail'].'&hash='.$hash.'">http://YourIP/sign/email/email_ck.php?email='.$user_info['E-mail'].'&hash='.$hash.'</a>';
if(isset($_POST['sign_ok'])) {
    $to = $user_info['E-mail'];  // 입력한 이메일로 메일 발송
    $subject = "Tae il's 이메일인증";  // 입력한 제목글
    $from = "dev@gmail.com";

    $headers[] = "From: ".$from;  // 메일이 발송되었을때 보낸사람이 보여지는 부분
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    mail($to, $subject, $message, implode("\r\n", $headers));
}