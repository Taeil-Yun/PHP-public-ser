<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once('../lib/PHPMailer-master/src/Exception.php');
require_once('../lib/PHPMailer-master/src/PHPMailer.php');
require_once('../lib/PHPMailer-master/src/SMTP.php');

//function mailer($email) {
    // the true param means it will throw exceptions on errors, which we need to catch
    $mail = new PHPMailer(true);
    // telling the class to use SMTP
    $mail->IsSMTP();
    // email 보낼때 사용할 서버를 지정
    $mail->Host = "smtp.gmail.com";
    // SMTP 인증을 사용함
    $mail->SMTPAuth = true;
    // email 보낼때 사용할 포트를 지정
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl"; // SSL을 사용함
    $mail->Username = "test.dev@gamil.com"; // Gmail 계정
    $mail->Password = "password"; // 패스워드
    $mail->SMTPDebug = 2;
    $mail->CharSet = "utf-8";
    $mail->SetFrom('test.dev@gmail.com', 'test'); // 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
    $mail->AddAddress('test@gmail.com'); // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
    $mail->Subject = 'test'; // 메일 제목
    $mail->isHtml(true);
    $mail->Body = "test";

    if($mail->send()) {
        return true;
    } else {
        return false;
    }
//}
//echo mailer('test@gmail.com');