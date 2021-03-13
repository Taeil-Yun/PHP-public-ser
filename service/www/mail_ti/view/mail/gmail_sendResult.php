<?php
$path = $_SERVER["DOCUMENT_ROOT"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gmail IMAP Send</title>
    <link rel="stylesheet" href="/static/css/mail_send.css">
    <script src="/static/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/static/js/search.js"></script>
    <script type="text/javascript" src="/static/js/gmail/mail_send.js?ver=0"></script>
    <script type="text/javascript" src="/static/js/gmail/mail_sendResult.js?ver=0"></script>
</head>
<body>

<section class="left_content">
    <?php
    include $path . "/view/category/category.html";
    ?>
</section>

<section class="right_content" style="width: calc(100% - 400px);">
    <?php
    include $path . "/view/category/nav.html";
    ?>

    <!--내용 div-->
    <div class="send_result_div state_success">
        <img src="/static/img/paper-plane-bg.png" width="100px">
        <div id="plane_box" class="success_plane"></div>
        <div class="mail_send_txt">메일을 성공적으로 보냈습니다.</div>
        <a href="/view/mail/gmail.php?vmbox=0">받은메일함가기</a>
        <span>|</span>
        <a href="/view/mail/gmail_send.php?stype=new">메일쓰기</a>
    </div>

    <div class="send_result_div state_fail">
        <img src="/static/img/paper-plane-bg.png" width="100px">
        <div id="plane_box" class="fail_plane"></div>
        <div class="mail_send_txt">메일을 보내는데 실패하였습니다.</div>
        <a href="/view/mail/gmail_send.php?stype=new">메일쓰기</a>
    </div>


</section>

</body>
</html>