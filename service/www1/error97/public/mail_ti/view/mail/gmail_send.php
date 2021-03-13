<?php
$path = $_SERVER["DOCUMENT_ROOT"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gmail IMAP Send</title>
    <link rel="stylesheet" href="/static/css/mail_send.css?ver=4">
    <script src="/static/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/static/js/search.js"></script>
    <script type="text/javascript" src="/static/js/gmail/mail_send.js?ver=5"></script>
</head>
<body>

<!--로딩-->
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

    <!--버튼 div-->
    <div class="btn_div">
        <button type="button" id="mail_send" class="btn_send_style font_bold"><img
                    src="/static/img/red_arrow.png"> 보내기
        </button>
        <button type="button" class="btn_send_style">임시저장</button>
    </div>

    <!--내용 div-->
    <div class="content_div">
        <table class="send_table">
            <tbody>
            <tr class="loc_not_me">
                <th>받는사람</th>
                <td><input type="email" id="gm_to"></td>
            </tr>
            <tr class="loc_not_me">
                <th>참조</th>
                <td><input type="email" id="gm_references" multiple></td>
            </tr>
            <tr>
                <th>제목</th>
                <td><input type="text" id="gm_subject"></td>
            </tr>
            <tr>
                <th>파일첨부</th>
                <td>
                    <span class="file_span" style="height:40px;">
                        <div class="file_div"></div>
                    <input multiple="multiple" name="files[]" id="files" type="file"
                           style="line-height: 19px;vertical-align: top;margin: 0px 3px;">
                    </span>
                    <div class="fileList"></div>
                </td>
            </tr>
            </tbody>
        </table>
        <textarea placeholder="내용을 입력하세요." id="gm_content"></textarea>
    </div>


</section>

</body>
</html>