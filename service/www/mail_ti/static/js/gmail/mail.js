$(function () {
    var vmbox = getParameter("vmbox");
    var page = getParameter('page');
    var search_value = getParameter('search_value');
    if (page == undefined) page = 1;
    if (search_value == undefined) search_value = "";
    load(vmbox, page, search_value);

    //체크박스 all
    $("#chkall").click(function () {
        if ($("#chkall").prop("checked")) {
            $("input[name=chk]").prop("checked", true);
        } else {
            $("input[name=chk]").prop("checked", false);
        }
    });
});

function load(vmbox, page, search_value) {
    var url = location.href;
    var url = url.split("?")[0];

    $.ajax({
        type: "POST",
        url: "/controller/gmail/select_mail.php",
        data: JSON.stringify({"vmbox": vmbox, "page": page, "search_value": search_value}),
        dataType: "json",
        success: function (data) {
            if (data.state == 200) {
                $('.mail_list > tbody').empty();
                $.each(data.message, function () {

                    //보낸사람
                    var gm_from = (this['gm_from'].split('<'));
                    gm_from = (gm_from[0].trim() == "") ? gm_from[1].replace('>', "") : gm_from[0];

                    //받는사람
                    var gm_to = (this['gm_to'].split('<'));
                    gm_to = (gm_to[0].trim() == "") ? gm_to[1].replace('>', "") : gm_to[0];

                    var mailer = (vmbox == 1 || vmbox == 2) ? gm_to : gm_from;

                    //읽음
                    var gm_seen_img = (this["gm_seen"] == 0) ? "close_mail" : "open_mail";
                    var seen_bold = (this['gm_seen'] == 0) ? " class='seen_bold'" : "";

                    //중요 메일함
                    var gm_star = (this['gm_star'] == 1) ? "yellow_star" : "gray_star";

                    //파일
                    var file_img = (this['gm_file'] == "" || null) ? "" : "<img src='/static/img/clip.png' width='12px' style='margin-top: 2px;'>"

                    //일시
                    var gm_udate = getFormatDate(new Date(this['gm_udate'] * 1000));

                    //사이즈
                    var gm_size = (this['gm_size'] > 1000) ? (this['gm_size'] / 1000) + "KB" : this["gm_size"] + "B";

                    var send_me = (gm_from == gm_to) ? "<div class='send_me_div'>내게쓴메일</div>" : "";

                    $(".mailData").append(
                        "<tr" + seen_bold + "><td style='text-align:center;width:25px;'><input type='checkbox' name='chk' id=" + this['gm_idx'] + " style='vertical-align: middle;'/></td>" +
                        "<td style='text-align:center;width:25px;'><img onclick='javascript:update_btn(\"gm_star\"," + this['gm_star'] + "," + this['gm_idx'] + ")' src='/static/img/" + gm_star + ".png' width='18px' style='vertical-align: middle;'></td>" +
                        "<td style='text-align:center;width:25px;'><img onclick='javascript:update_btn(\"gm_seen\"," + this['gm_seen'] + "," + this['gm_idx'] + ")' src='/static/img/" + gm_seen_img + ".png' width='18px' style='vertical-align: middle;'></td>" +
                        "<td width='150px;' style='padding-left:15px;'>" + mailer + "</td>" +
                        "<td style='text-align:center;width:25px;'>" + file_img + "</td>" +
                        "<td><a class='href' href='javascript:mailview(" + vmbox + "," + this['gm_idx'] + "," + this['gm_seen'] + ")'>" + this['gm_subject'] + "</a>" + send_me + "</td>" +
                        "<td class='mail_etc'>" + gm_udate + "</td>" +
                        "<td class='mail_etc'>" + gm_size + "</td></tr>"
                    );
                });

                /**
                 * 페이징
                 */
                var str = '';
                str += "<li><a href='" + url + "?vmbox=" + vmbox + "&page=1&search_value=" + search_value + "' class='paging_text'><img src='/static/img/start.png' alt='start'></a></li>";
                if (data.paging.block_start > 10) {
                    str += "<li><a href='" + url + "?vmbox=" + vmbox + "&page=" + (Number(page) - 1) + "&search_value=" + search_value + "' class='paging_text'><img src='/static/img/foward.png' alt='forward'></a></li>";
                }
                for (i = data.paging.block_start; i < data.paging.block_end + 1; i++) {
                    if (page == i) {
                        str += "<li><a href='" + url + "?vmbox=" + vmbox + "&page=" + i + "&search_value=" + search_value + "' class='now'>" + i + "</a></li>";
                    } else {
                        str += "<li><a href='" + url + "?vmbox=" + vmbox + "&page=" + i + "&search_value=" + search_value + "'>" + i + "</a></li>";
                    }
                }
                if (data.paging.block_end < data.paging.total_page) {
                    str += "<li><a href='" + url + "?vmbox=" + vmbox + "&page=" + (Number(page) + 1) + "&search_value=" + search_value + "' class='paging_text'><img src='/static/img/next.png' alt='next'></a></li>";
                }
                str += "<li><a href='" + url + "?vmbox=" + vmbox + "&page=" + data.paging.total_page + "&search_value=" + search_value + "' class='paging_text'><img src='/static/img/end.png' alt='end'></a></li>";
                $(".paging").empty();
                $(".paging").append("<ul>" + str + "</ul>");

                $(".mail_search_txt").val(search_value);

            } else if (data.state == 400) {
                var error_msg = (getParameter('search_value') == undefined) ? "받은 메일이 없습니다." : "검색 결과가 없습니다.";

                $(".mailData").append(
                    "<tr><td colspan='7' style='text-align: center;'>" + error_msg + "</td></tr>"
                );
            } else {
                alert(data.message);
            }
        }, error: function (a, b, c) {
            console.log(c);
        }
    });
}


//제목 클릭시 읽음여부에 따라 gm_seen 업데이트 후 메일뷰 페이지로 이동
function mailview(mbox, gmno, seen) {
    if (seen == 0) {
        var trans_seen = (seen == 0) ? 1 : 0;
        $.ajax({
            type: "POST",
            url: "/controller/gmail/update_mail.php",
            dataType: "json",
            data: JSON.stringify({"gmno": gmno, "gm_seen": trans_seen}),
            success: function (data) {
                location.href = '/view/mail/gmail_view.php?vmbox=' + mbox + '&gmno=' + gmno;
            }
        });
    } else {
        location.href = '/view/mail/gmail_view.php?vmbox=' + mbox + '&gmno=' + gmno;
    }
}

function insert() {
    $.ajax({
        type: "GET",
        url: "/controller/gmail/insert_mail.php",
        dataType: "json",
        success: function (data) {
            if (data.state == 200) {
                alert("업데이트 되었습니다.");
                location.reload();
            } else {
                alert(data.message);
            }
        }, beforeSend: function () {
            $('.wrap-loading').removeClass('display-none');
        }
        , complete: function () {
            $('.wrap-loading').addClass('display-none');
        }
    });
}

function search_mail() {
    var url = location.href;
    url = url.split("?")[0];

    var vmbox = getParameter("vmbox");
    var search_value = $(".mail_search_txt").val();
    if (search_value == "") {
        alert("검색어를 입력하세요.");
        return;
    }
    url = url + "?vmbox=" + vmbox + "&page=1&search_value=" + search_value;
    location.href = url;
}