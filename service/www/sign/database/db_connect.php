<?php
$user_info = array(
    'ID'=>$_POST['id_'], 'Password'=>$_POST['password_'], 'Last_Name'=>$_POST['f_name_'],
    'Middle_Name'=>$_POST['m_name_'], 'First_Name'=>$_POST['l_name_'], 'Nick_Name'=>$_POST['nick_'],
    'E-mail'=>$_POST['email_'], 'Phone_Number'=>$_POST['phone_'], 'Country'=>$_POST['country']
);

$info_country = $user_info['Country'];
$info_id = $user_info['ID'];
$info_nick = $user_info['Nick_Name'];
$info_email = $user_info['E-mail'];
$info_phone = $user_info['Phone'];
$info_lastname = $user_info['Last_Name'];
$info_midname = $user_info['Middle_Name'];
$info_firstname = $user_info['First_Name'];

$pwd_hash = password_hash($user_info['Password'], PASSWORD_BCRYPT);

// config info
$db_host = "YOUR HOST";
$db_username = "YOUR USER NAME";
$db_password = "YOUR PASSWORD";
$db_name = "YOUR DATABASE";
$db_port = "YOUR PORT";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port);
mysqli_set_charset($conn, "utf8");

if(!$conn) { echo "Unable to connect to DB: " . mysqli_error($conn); exit; }
$sql = "INSERT INTO `member` VALUES ('{$info_country}', '{$info_id}', '{$pwd_hash}', '{$info_nick}', '{$info_email}', '{$info_phone}', '{$info_lastname}', '{$info_midname}', '{$info_firstname}', '')";
mysqli_query($conn, $sql);
mysqli_close($conn);

include_once '../email/send_mail.php';

/*********************************************************/
$email_conn = mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port);
mysqli_set_charset($email_conn, "utf8");

if(!$email_conn) { echo "Unable to connect to DB: " . mysqli_error($email_conn); exit; }
mysqli_query($email_conn, "INSERT INTO `email_auth` VALUES ('{$info_id}', '{$info_email}', '{$hash}', '')");
mysqli_close($email_conn);
/*********************************************************/