<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/config/Database.php";
require_once $path . "/objects/gmail/gmail.php";
require_once $path . "/objects/gmail/gmail_imap.php";

$db = new Database('WRITE', 'WRITE_MAIL');
$mail = new Gmail();
$gmail_IMAP = new Gmail_imap();

//스팸메일함 인코딩
$spam = mb_convert_encoding("[Gmail]/스팸함", "UTF7-IMAP", "utf-8");
//가져올 메일 박스
$mail_box = array("INBOX", $spam);

$result = array();

for ($i = 0; $i < count($mail_box); $i++) {
    if ($param = $gmail_IMAP->import_mail($mail_box[$i])) {
        for ($j = 1; $j <= count($param); $j++) {
            if ($mail->insertData($db, $param[$j])) {
                $move = mb_convert_encoding("[Gmail]/휴지통", "UTF7-IMAP", "utf-8");
                imap_mail_move($gmail_IMAP->conn, $param[$j]['gm_uid'], $move, CP_UID);
                array_push($result, "true");
            } else {
                array_push($result, "false");
            }
        }
    }
}
if (in_array(array("false"), $result)) {
    echo json_encode(array("state" => 500, "message" => "Insert fail."));
} else {
    echo json_encode(array("state" => 200, "message" => "Insert Success."));
}

/*IMAP 완전 삭제 코드 : imap_delete($gmail_IMAP->conn, $param[$i]['gm_uid'], FT_UID);*/
?>

