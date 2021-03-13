<?php

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/config/Database.php";
include_once $path . "/objects/member/member.php";
include_once $path . "/objects/gmail/gmail.php";

$db_mem_s = new Database('READ', 'READ_MEMBER');
$db_mail_i = new Database('WRITE', 'WRITE_MAIL');

$member = new Member();
$mail = new Gmail();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {

    if ($result = $member->selectMem($db_mem_s, "ex_mem_info.mem_nickname='" . $data['mem_nickname'] . "'")) {
        //가져온 회원번호로 아이디를 검색

        $mail->gm_subject = $data['gm_subject'];
        $mail->gm_from = $result[0]['mem_id'];
        $mail->gm_to = ($data['gm_to'] == "") ? $result[0]['mem_id'] : $data['gm_to'];
        $mail->gm_references = $data['gm_references'];
        $mail->gm_reply_to = $result[0]['mem_id'];
        $mail->gm_content = $data['gm_content'];
        $mail->gm_file = $data['gm_file'];

        if ($mail->mailer()) {

            $param = array(
                "gm_subject" => $mail->gm_subject,
                "gm_from" => "<" . $mail->gm_from . ">",
                "gm_to" => "<" . $mail->gm_to . ">",
                "gm_references" => ($mail->gm_references == "") ? "" : "<" . $mail->gm_references . ">",
                "gm_reply_to" => "<" . $mail->gm_from . ">",
                "gm_size" => 0,
                "gm_date" => $mail->gm_date,
                "gm_message_id" => $mail->gm_message_id,
                "gm_udate" => time(),
                "gm_content" => $mail->gm_content,
                "gm_file" => $mail->gm_file,
                "gm_mbox" => 2
            );

            if ($mail->insertData($db_mail_i, $param)) {
                echo json_encode(array("state" => 200, "message" => "success."));
            } else {
                echo json_encode(array("state" => 500, "message" => "Insert Mail fail."));
            }

        } else {
            echo json_encode(array("state" => 500, "message" => "Send Mail fail."));
        }

    } else {
        echo json_encode(array("state" => 404, "message" => "Not found user id."));
    }

} else {
    //받은 데이터가 없는 경우
    echo json_encode(array("state" => 412, "message" => "No data has been transferred."));
}


?>