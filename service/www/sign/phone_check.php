<input type="text" id="phone_" placeholder="dd">
<input type="button" id="phone_c" value="a">
<?php
//$con = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE", "PORT") or die(mysqli_error($con));
//
//$tel_search = mysqli_query($con, "SELECT mem_key, hash, ck FROM `phone_auth` WHERE mem_key='{$_tel}' AND hash='{$_msg}' AND ck='0'") or die(mysqli_error($con));
//$tel_match  = mysqli_num_rows($tel_search);
//
//if($tel_match > 0) {
//    mysqli_query($con, "UPDATE `phone_auth` SET ck='1' WHERE mem_key='".$_tel."' AND hash='".$_msg."' AND ck='0'") or die(mysqli_error($con));
//    mysqli_close($con);
//    include_once './js/phone_check_ok.php';
//} else {
//    mysqli_close($con);
//    include_once './js/phone_check_fail.php';
//}

$phone_ = "<script>document.getElementById('phone_').value</script>";
echo $phone_;
$rep = str_replace("-", "", "010-0000-0000");
echo $rep;
//     $replace_p = str.replace("-", "", $phone_);
//     $con = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE", "PORT") or die(mysqli_error($con));
//
//     $tel_search = mysqli_query($con, "SELECT hash FROM `phone_auth` WHERE mem_key='".$replace_p."' AND ck='0' ORDER BY mem_key DESC LIMIT 1") or die(mysqli_error($con));
//     $tel_match  = mysqli_num_rows($tel_search);
//     if($tel_match ==  document.getElementById("cre_phone").value) {
//         mysqli_query($con, "UPDATE `phone_auth` SET ck='1' WHERE mem_key='".$replace_p."' AND ck='0'") or die(mysqli_error($con));
//         mysqli_close($con);
//         include_once './js/phone_check_ok.php';
//     } else {
//         mysqli_close($con);
//         include_once './js/phone_check_fail.php';
//     }