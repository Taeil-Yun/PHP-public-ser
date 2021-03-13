<?php

if (isset($_GET['file_name'])) {

    $is_file_exist = file_exists("../../static/file/" . $_GET['file_name']);

    if ($is_file_exist) {
        $filepath = '../../static/file/' . $_GET['file_name'];
        $filesize = filesize($filepath);
        $filename = mb_basename($filepath);
        if (is_ie()) $filename = utf2euc($filename);

        header("Pragma: public");
        header("Expires: 0");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: $filesize");

        readfile($filepath);
    } else {
        echo json_encode(array("state" => 500, "message" => "not found file."));
    }

} else {
    echo json_encode(array("state" => 404, "message" => "not received file_name."));
}

/**
 * 사용함수
 */
//받아온 파일 path 에서 filename 분리
function mb_basename($path)
{
    return end(explode('/', $path));
}

//IE8 이거나 IE11인 경우 cp949로 변환
function utf2euc($str)
{
    return iconv("UTF-8", "cp949//IGNORE", $str);
}

//IE8 or IE11을 확인
function is_ie()
{
    if (!isset($_SERVER['HTTP_USER_AGENT'])) return false;
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11
    return false;
}

?>