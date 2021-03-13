<?php
$path = $_SERVER["DOCUMENT_ROOT"];

include_once $path . "/config/Database.php";
include_once $path . "/objects/member/device.php";
include_once $path . "/objects/member/member.php";
include_once $path . "/objects/gmail/gmail.php";

include_once $path . "/objects/paging.php";


$db_mail_s = new Database('READ', 'READ_MAIL');
$brd_post = new Gmail();
$paging = new Paging();

$data = json_decode(file_get_contents("php://input"), true);

$page = $data['page'];
$option = $data['search_option'];
$value = $data['search_value'];
$option = ($value == "") ? "" : $option;

switch ($option) {
    case "all":
        $where = "brd_title LIKE '%" . $value . "%' or brd_content LIKE '%" . $value . "%'";
        break;
    case "brd_title":
        $where = "brd_title LIKE '%" . $value . "%'";
        break;
    case "brd_content":
        $where = "brd_content LIKE '%" . $value . "%'";
        break;
}

if ($paging->calculator($db_mail_s, 'ex_sns_mail', $page, 'example.ex_sns_mail as g ON sc_sns_mail.gm_idx=g.gm_idx', $where)) {

    if ($mail_post_list = $brd_post->selectData($db_mail_s, $where, $limit = $paging->start_num . "," . $paging->list)) {
        if (count($mail_post_list) != 1) {
            array_shift($mail_post_list);
            $paging = array("block_start" => $paging->block_start, "block_end" => $paging->block_end, "total_page" => $paging->total_page);
            echo json_encode(array("state" => 200, "value" => $mail_post_list, "paging" => $paging));
        } else {
            echo json_encode(array("state" => 204, "message" => "no result"));
        }
    } else {
        echo json_encode(array("state" => 500, "message" => "Select Post List : Internet Server Error."));
    }

} else {

    echo json_encode(array("state" => 500, "message" => "Paging cannot completed."));

}


?>