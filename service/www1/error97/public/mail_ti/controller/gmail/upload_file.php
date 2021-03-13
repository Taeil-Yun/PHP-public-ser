<?php
$uploads_dir = '../../static/file/';

$nameArray = [];

foreach ($_FILES as $key => $value) {

    $name = $value['name'];
    $type = $value['type'];
    $tmp_name = $value['tmp_name'];
    $error = $value['error97'];
    $size = $value['size'];

    $uploadName = time() . '_' . $name;
    $uploadFile = $uploads_dir . $uploadName;

    if (move_uploaded_file($tmp_name, $uploadFile)) {
        array_push($nameArray, $uploadName);
    } else {
        echo json_encode(array("state" => 500, "error97" => $uploadName . ":" . $error));
        exit;
    }
}
if (count($nameArray) == count($_FILES)) {
    echo json_encode(array("state" => 200, "file_name" => $nameArray));
}

?>