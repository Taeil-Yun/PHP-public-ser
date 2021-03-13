<?php
$con = mysqli_connect("YOUR HOST", "YOUR USER NAME", "YOUR PASSWORD", "YOUR DATABASE", "YOUR PORT") or die(mysqli_error($con));
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $email = mysqli_escape_string($con, $_GET['email']);
    $hash = mysqli_escape_string($con, $_GET['hash']);

    $search_ = mysqli_query($con, "SELECT mem_key, hash, ck FROM `email_auth` WHERE mem_key='{$email}' AND hash='{$hash}' AND ck='0'") or die(mysqli_error($con));
    $match_  = mysqli_num_rows($search_);

    $search_emailAuth = mysqli_query($con, "SELECT email, state FROM `member` WHERE email='{$email}' AND state='0'") or die(mysqli_error($con));
    $match_emailAuth  = mysqli_num_rows($search_emailAuth);

    if($match_ > 0 && $match_emailAuth > 0){
        mysqli_query($con, "UPDATE `email_auth` SET ck='1' WHERE mem_key='".$email."' AND hash='".$hash."' AND ck='0'") or die(mysqli_error($con));
        mysqli_query($con, "UPDATE `member` SET state='1' WHERE email='".$email."' AND state='0'") or die(mysqli_error($con));
        mysqli_close($con);
        echo '<div>Email authentication completed</div>';
    }else{
        mysqli_close($con);
        echo '<div>Authentication failed or account is already active.</div>';
    }
} else {
    mysqli_close($con);
    echo '<div>Please use the link sent by email.</div>';
}

//echo "<meta http-equiv='refresh' content='0; url=../main.php'>";