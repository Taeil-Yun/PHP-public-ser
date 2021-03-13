<html>
    <head></head>
    <body>
        <div>
            <?php
                $conn = mysqli_connect("HOST", "User ID", "PASSWORD", "DATABASE", "PORT") or die(mysqli_error($conn));
            ?>
        </div>
    </body>
</html>
<?php

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $email = mysqli_escape_string($conn, $_GET['email']);
    $hash = mysqli_escape_string($conn, $_GET['hash']);

    $search_ = mysqli_query($conn, "SELECT email, email_hash, email_ck FROM `member` WHERE email='{$email}' AND email_hash='{$hash}' AND email_ck='0'") or die(mysqli_error($conn));
    $match_  = mysqli_num_rows($search_);

    if($match_ > 0){
        mysqli_query($conn, "UPDATE `member` SET email_ck='1' WHERE email='".$email."' AND email_hash='".$hash."' AND email_ck='0'") or die(mysqli_error($conn));
        mysqli_close($conn);
        echo '<div>Email authentication completed</div>';
    }else{
        mysqli_close($conn);
        echo '<div>Authentication failed or account is already active.</div>';
    }
} else {
    mysqli_close($conn);
    echo '<div>Please use the link sent by email.</div>';
}