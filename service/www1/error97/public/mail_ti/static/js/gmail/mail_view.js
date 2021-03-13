$(function () {
    var vmbox = getParameter("vmbox");
    var gmno = getParameter("gmno");
    load(vmbox, gmno);
});

function load(vmbox, gmno) {
    $.ajax({
        type: "POST",
        url: "/controller/gmail/select_mail.php",
        data: JSON.stringify({"vmbox": vmbox, "gmno": gmno}),
        dataType: "json",
        success:
            function (data) {
                if (data.state == 200) {
                    $.each(data.message, function () {
                        console.log(data.message);
                        var gm_from = replaceMailFormat(this['gm_from']);
                        var gm_to = replaceMailFormat(this['gm_to']);
                        var references = (this['gm_references'] == "" || null) ? "" : "<tr class='sfont'><th style='width:60px;'>참&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;조</th><td class='references'>" + replaceMailFormat(this['gm_references']) + "</td></tr>";
                        var file = "";
                        if (this['gm_file'] != '' || null || undefined || 0 || NaN) {
                            var file_arr = this['gm_file'].split(',');
                            var file_name = "";
                            for (i = 0; i < file_arr.length; i++) {
                                file_name += "<div class='view_file_box'><a href='javascript:fileDown(\"" + file_arr[i] + "\")'><img src='/static/img/download.png'>" + file_arr[i] + "</a></div>";
                            }
                            file = "<tr class='sfont'><td class='file' colspan='2'><div class='file_count'><img src='/static/img/clip.png'>첨부파일 <span style='font-weight: 500'>총 " + file_arr.length + "건</span></div>" + file_name + "</td></tr>";
                        }

                        // change to check_box reply when mail is selected
                        $(".head_box").prepend(
                            $(".head_chk_frame").css('display', 'none'),
                            "<button class='btn_head' style='margin-right:-5px;' onclick='reply_mail();'>답장</button>"
                        );

                        $(".mailData").append(
                            "<tr><td class='subject' colspan='2'>" + this['gm_subject'] + "</td></tr>" +
                            "<tr class='sfont'><th style='width:60px;'>보낸사람</th><td class='from'>" + gm_from + "</td></tr>" +
                            "<tr class='sfont'><th style='width:60px;'>받는사람</th><td class='to'>" + gm_to + "</td></tr>" +
                            references +
                            "<tr><td colspan='2'><hr></td></tr>" + file +
                            "<tr><td class='content' colspan='2'><iframe frameborder='0' scrolling='NO' class='iframe' id='iframe" + this['gm_idx'] + "'></iframe></td></tr>"
                        );
                        var $frame = $("#iframe" + this['gm_idx']);
                        var doc = $frame[0].contentWindow.document;
                        var $body = $('body', doc);
                        $body.html(this['gm_content']);
                        IframeResize(gmno);
                    });
                } else {
                    if (data.message != "No Result.") {
                        alert(data.message);
                    }
                }
            }, error: function (a, b, c) {
            console.log(c);
        }
    });
}

function replaceMailFormat(string) {
    return string.replace('<', "&lt").replace('>', "&gt");
}

function IframeResize(id) {
    var ifrm = document.getElementById("iframe" + id);
    var the_height = ifrm.contentWindow.document.body.scrollHeight;
    ifrm.height = the_height;
}

function fileDown(file_name) {
    $.ajax({
        url: "/controller/gmail/download_file.php",
        data: JSON.stringify({"file_name": file_name}),
        dataType: "JSON",
        type: "GET",
        success: function (/*실패 시*/) {
            alert("파일이 손상되었거나 다운로드 받을 수 없는 파일입니다.");
        }, error: function (/*성공 시*/) {
            location.href = "/controller/gmail/download_file.php?file_name=" + file_name;
        }
    });
}