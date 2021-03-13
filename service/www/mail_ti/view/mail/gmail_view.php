<?php
$path = $_SERVER["DOCUMENT_ROOT"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mail</title>
    <script src="/static/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="/static/css/mail_view.css?ver=10">
    <script type="text/javascript" src="/static/js/search.js"></script>
    <script type="text/javascript" src="/static/js/gmail/mail_view.js?ver=10"></script>
    <script type="text/javascript" src="/static/js/gmail/nav.js?ver=1"></script>
</head>
<body>
<section class="left_content">
    <?php
    include $path . "/view/category/category.html";
    ?>
</section>
<section class="mail_content">
    <div style="width:95%;margin:auto">
        <?php
        include $path . "/view/category/nav.html";
        ?>
    </div>
    <div class="mail_div">
        <table class="mail_box">
            <tbody class="mailData">
            </tbody>
        </table>
    </div>
</section>
</body>
</html>