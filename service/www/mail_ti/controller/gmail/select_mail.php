<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/config/Database.php";
include_once $path . "/objects/member/device.php";
include_once $path . "/objects/member/member.php";
include_once $path . "/objects/gmail/gmail.php";
include_once $path . "/objects/paging.php";

$db_dvc_s = new Database('READ', 'READ_DEVICE');
$db_mem_s = new Database('READ', 'READ_MEMBER');
$db_mail_s = new Database('READ', 'READ_MAIL');

$device = new Device();
$mail = new Gmail();
$member = new Member();
$paging = new Paging();

$data = json_decode(file_get_contents('php://input'), true);


if ($device->dvcExists($db_dvc_s, "dvc_id='" . $_COOKIE['did'] . "'")) {

    if ($mem_result = $member->selectMem($db_mem_s, "ex_mem_info.mem_no =" . $device->mem_no)) {

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

        $where .= isset($data['gmno']) ? " and gm_idx=" . $data['gmno'] : "";
        $where .= ($vmbox == 1) ? " and gm_from like '%<" . $mem_result[0]['mem_id'] . ">%'" : " and gm_to like '%<" . $mem_result[0]['mem_id'] . ">%'";

        $search = '';
        //검색
        if ($data['search_value'] != "") {

            $search = " and  gm_subject LIKE '%" . $data['search_value'] . "%' 
                        or " . $where . " and gm_content LIKE '%" . $data['search_value'] . "%'";
            if ($vmbox == 1) {
                $search .= " or " . $where . " and gm_to LIKE '%" . $data['search_value'] . "%'";
            } else if ($vmbox == 0 or $vmbox == 3 or $vmbox == 4 or $vmbox == 5) {
                $search .= " or " . $where . " and gm_from LIKE '%" . $data['search_value'] . "%'";
            }
        }
        $where = $where . $search;

        $page = $data['page'];

        if ($paging->calculator($db_mail_s, 'ex_sns_mail', $page, null, $where)) {

            if ($result = $mail->selectData($db_mail_s, '*', null, $where, $limit = $paging->start_num . "," . $paging->list)) {
                if ($result == "no result") {
                    echo json_encode(array("state" => 400, "message" => "No Result."));
                } else {
                    array_shift($result);
                    if (count($result) == 0) {
                        echo json_encode(array("state" => 400, "message" => "No Result."));
                    } else {
                        $paging = array("block_start" => $paging->block_start, "block_end" => $paging->block_end, "total_page" => $paging->total_page);
                        echo json_encode(array("state" => 200, "message" => $result, "paging" => $paging));
                    }
                }
            } else {
                echo json_encode(array("state" => 500, "message" => "Unable to retrieve mail Database."));
            }

        } else {
            //paging fail
            echo json_encode(array("state" => 000, "message" => "Paging cannot completed."));
        }

    } else {
        //id Exist : X
        echo json_encode(array("state" => 500, "message" => "Login error97."));
    }
} else {
    echo json_encode(array("state" => 401, "message" => "error97 : Login Please."));
    setcookie('did', '', time() - 86400, '/');
    exit;
}

?>