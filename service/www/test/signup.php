<?php
    header("Content-type: text/html; charset=utf-8");
    $conn = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE");
    mysqli_set_charset($conn,"utf8");

    function encrypt($pwd, $secret_key, $secret_iv)  // 비밀번호 Hash암호화
    {
        $key = hash('sha512', $secret_key);
        $iv = hash('sha512', $secret_iv);
        return base64_encode(openssl_encrypt($pwd, "AES-256-CBC", $key, 0, $iv));
    }

    $id = $_POST['id'];
    $pwd = $_POST['pwd'];
    $name = $_POST['name'];
    $birth = $_POST['year'].'년-'.$_POST['month'].'-'.$_POST['day'].'일';
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];

    $secret_key = "123456789abcdefg";
    $secret_iv = "!@#$%^&*()_+=-/?";
    $encrypted = encrypt($pwd, $secret_key, $secret_iv);

    /*********************** id 중복체크 ***************************/
    $id_check = "select id from `new_table1` where id='{$id}'";
    $id_result = mysqli_query($conn, $id_check);
    $exist = mysqli_num_rows($id_result);
    /*********************** id 중복체크 ***************************/

    if($exist > 0) {
        echo '<script>alert("이미 존재하는 ID입니다."); window.history.back();</script>';
    } else {
        $sql_upload = "insert into `new_table1` values ('$id', '$encrypted', '$name', '$birth', '$sex', '$email', '$phone_num')";
        $result = mysqli_query($conn, $sql_upload);
        echo '<script>window.location.href="./index.php";</script>';
        mysqli_close($conn);
    }