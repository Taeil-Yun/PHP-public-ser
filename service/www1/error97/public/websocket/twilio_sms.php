<?php
$url = "https://api.twilio.com/2010-04-01/Accounts/본인 계정 시드/Messages.json";
// url 변경금지 ex) https://api.twilio.com/2010-04-01/Accounts/본인 계정 시드/Messages.json

$from = "+123456789";  // 발송번호 ( 변경금지 / 고정됨 )
$to = "+8201000000000"; // ( 편집가능 / 국제발신 / 예 : +821090595426 )
$body = "테스트 문자"; // ( 편집가능 )

$id = "시드"; // (변경금지) / 계정 시드
$token = "토큰"; // (변경 금지) / 인증 토큰

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
