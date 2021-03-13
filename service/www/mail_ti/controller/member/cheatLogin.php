<?php

if (isset($_COOKIE['did'])) {
    setcookie('did', '', time() - 86400, '/');
    echo json_encode(array("state" => 200, "message" => "Logout success."));
} else {
    setcookie('did', '5338', time() + 86400, '/');
    echo json_encode(array("state" => 201, "message" => "Login success."));
}

?>