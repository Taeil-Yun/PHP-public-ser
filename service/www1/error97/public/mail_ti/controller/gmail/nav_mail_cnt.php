<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/config/Database.php";
include_once $path . "/objects/member/member.php";
include_once $path . "/objects/gmail/gmail.php";

$db_mem_s = new Database('READ', 'READ_MEMBER');
$db_mail_s = new Database('READ', 'READ_MAIL');

$mail = new Gmail();
$member = new Member();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data)) {
    $mem_nickname = $data['mem_nickname'];

    if ($mem_result = $member->selectMem($db_mem_s, "mem_info.mem_nickname = '" . $mem_nickname . "'")) {

        $vmbox = $data['vmbox'];
        $where = '';
        switch ($vmbox) {
            case 0 :
                $where .= "gm_mbox = 0 and gm_deleted = 0";
                break;
            case 1:
            case 2:
                $where .= "gm_mbox = 2 and gm_deleted = 0";
                break;
            case 3 :
                $where .= "gm_star = 1 and gm_deleted = 0";
                break;
            case 4 :
                $where .= "gm_mbox = 1 and gm_deleted = 0";
                break;
            case 5 :
                $where .= "gm_deleted = 1";
                break;
        }

        $where .= ($vmbox == 1) ? " and gm_from like '%<" . $mem_result[0]['mem_id'] . ">%'" : " and gm_to like '%<" . $mem_result[0]['mem_id'] . ">%'";

        if ($result = $mail->selectData($db_mail_s, 'count(if(gm_seen=0,1,null)) as unseen_cnt,count(*) as total_cnt', null, $where)) {
            echo json_encode(array("state" => 200, "unseen_cnt" => $result[0]['unseen_cnt'], "total_cnt" => $result[0]['total_cnt']));
        } else {
            echo json_encode(array("state" => 500, "message" => "Error."));
        }

    } else {
        echo json_encode(array("state" => 400, "message" => "Not found User info."));
    }


} else {
    echo json_encode(Array("state" => 400, "message" => "Not found Data."));
}


?>