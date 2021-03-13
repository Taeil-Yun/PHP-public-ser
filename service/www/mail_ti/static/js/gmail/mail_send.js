$(function () {
    var stype = getParameter('stype');

    if (stype == "reply") {
        var gm_title = getParameter('gm_title');
        var gm_to = replaceMailFormat(getParameter('gm_to'));
        console.log(gm_to);
        $("#gm_subject").val('[RE]: ' + gm_title);
        $("#gm_to").val(gm_to);
    }

    let fileBuffer = []; // 파일내용을 넣을 배열

    // 파일 복수 선택 (선택 시 파일내용 출력)
    $('#files').change(function () {
        let html = '';
        const target = document.getElementsByName('files[]'); // 파일 값을 가져오는 변수
        Array.prototype.push.apply(fileBuffer, target[0].files); // fileBuffer 내에 파일내용을 담음

        $.each(fileBuffer, function (index, file) {
            var fileName = file.name;
            var fileName_arr = fileName.split('.');
            var fileType = fileName_arr[fileName_arr.length - 1].toLowerCase();

            if (fileType == "png" || fileType == "jpg" || fileType == "jpeg" || fileType == "gif" || fileType == "BMP" || fileType == "SVG") {
                fileType = "png";
            } else if (fileType == "png" || fileType == "xlsx" || fileType == "hwp" || fileType == "pdf" || fileType == "pptx" || fileType == "docx") {
                fileType = fileType;
            } else {
                fileType = "etc";
            }

            html += "<div class='file_data' id='file_data" + index + "'>";
            html += "<div class='left_div'><img src='/static/img/" + fileType + ".png' width='20px'></div>";
            html += "<div class='right_div'>";
            html += "<div class='file_remove'> </div>"
            html += "<div class='file_name'>" + file.name + "</div>";
            html += "<div class='file_size'>" + file.size + "KB</div>";
            html += "</div>";
            html += '</div>';

            $('.fileList').html(html);
        });
    });

    // 파일 선택 취소
    $(document).on('click', '.file_remove', function () {
        const fileIndex = $(this).parent().parent().index();
        const fileId = $(this).parent().parent().attr('id');
        fileBuffer.splice(fileIndex, 1);
        $('.fileList>div:eq(file' + fileIndex + ')').remove();
        $('#' + fileId).remove();
    });

    // 메일 전송

    $(document).on('click', '#mail_send', function () {
        var mem_nickname = $("#user_nickname").html();
        var gm_to = $("#gm_to").val();
        var gm_references = $("#gm_references").val();
        var gm_subject = $("#gm_subject").val();
        var gm_content = $("#gm_content").val();

        var stype = getParameter('stype');

        var exp1 = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;

        if (stype == "new") {
            if (gm_to == "") {
                alert("받는 사람을 입력해주세요.");
                return;
            } else if (!exp1.test(gm_to)) {
                alert("이메일 형식에 알맞게 작성하세요.");
                $("#gm_to").focus();
                return;
            }
        }

        if (mem_nickname == "") {
            alert("로그인 후 이용해주세요.");
            return;
        } else if (gm_references != "" && !exp1.test(gm_references)) {
            alert("이메일 형식에 알맞게 작성하세요.");
            $("#gm_references").focus();
            return;
        } else if (gm_subject == "") {
            alert("제목을 입력해주세요.");
            return;
        } else if (gm_content == "") {
            alert("내용을 입력해주세요.");
            return;
        }

        let formData = new FormData();
        for (i = 0; i < fileBuffer.length; i++) {
            formData.append(i, fileBuffer[i]);
        }

        if (fileBuffer.length == 0) {
            send_mail(mem_nickname, gm_to, gm_references, gm_subject, gm_content);
        } else {
//파일저장
            $.ajax({
                url: "/controller/gmail/upload_file.php",
                processData: false,
                contentType: false,
                type: "POST",
                dataType: "json",
                data: formData,
                success: function (data) {

                    /**
                     * 파일저장 SUCCESS : 파일명 : data.file_name
                     **/
                    if (data.state == 200) {

                        /**
                         * 메일 전송
                         **/
                        send_mail(mem_nickname, gm_to, gm_references, gm_subject, gm_content, data.file_name.join(','));

                    } else {
                        /**
                         * 파일저장 FAIL : 파일명 : data.file_name
                         **/
                        console.log(data.error);
                    }
                }, error: function (a, b, c) {
                    console.log(c);
                }
            });
        }
    });
});

function send_mail(mem_nickname, gm_to, gm_references, gm_subject, gm_content, gm_file = "") {
    var param = {
        'mem_nickname': mem_nickname,
        'gm_to': gm_to,
        'gm_references': gm_references,
        "gm_subject": gm_subject,
        "gm_content": gm_content,
        "gm_file": gm_file
    };

    param = JSON.stringify(param);

    $.ajax({
        url: "/controller/gmail/send_mail.php",
        type: "POST",
        dataType: "json",
        data: param,
        success: function (data) {
            if (data.state == 200) {
                location.href = "/view/mail/gmail_sendResult.php?state=success";
            } else {
                location.href = "/view/mail/gmail_sendResult.php?state=fail";
            }
        }, error: function (a, b, c) {
            console.log(c);
        }, beforeSend: function () {
            $('.wrap-loading').removeClass('display-none');
        }
        , complete: function () {
            $('.wrap-loading').addClass('display-none');
        }
    });
}

function replaceMailFormat(string) {
    return string.replace('<', "&lt").replace('>', "&gt");
}
