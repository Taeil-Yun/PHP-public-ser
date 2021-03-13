<?php
$path = $_SERVER["DOCUMENT_ROOT"];
?>
<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="UTF-8">
    <title>Gmail IMAP</title>
    <link rel="stylesheet" href="/static/css/mail_box.css?ver=9">
    <link rel="stylesheet" href="/static/css/paging.css">
    <script src="/static/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/static/js/search.js"></script>
    <script type="text/javascript" src="/static/js/gmail/mail.js?ver=19"></script>
    <script type="text/javascript" src="/static/js/date.js?ver=0"></script>
</head>
<body>

<div class="wrap-loading display-none">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"
       style="z-index:100; position:absolute; left:calc(100% / 2); top:calc(100% / 2)"></i>
</div>

<section class="left_content">
    <?php
    include $path . "/view/category/category.html";
    ?>
</section>
<section class="right_content" style="width: calc(100% - 400px);">
    <?php
    include $path . "/view/category/nav.html";
    ?>

    <div class="mail_box">
        <table class="mail_list">
            <tbody class="mailData">
            </tbody>
        </table>
        <div class="paging">
        </div>
    </div>
</section>

</body>
</html>