$(function () {
    get_mbox();
    user_name();
    isView();
    if (getParameter('stype') != undefined) {
        $(".nav_div").css("height", "120px");
        $(".head_box").css("display", "none");
    }
});

function user_name() {
    $.ajax({
        type: "GET",
        url: "/controller/member/user_info.php",
        dataType: "json",
        success: function (data) {
            if (data.state == 200) {
                $("#user_nickname").text(data.message['nickname']);
                load_msg_cnt();
            } else if (data.state == 500) {
                alert(data.message);
            }
        }, error: function (data) {
            console.log(data);
        }
    });
}

function load_msg_cnt() {
    var mem_nickname = document.getElementById('user_nickname').innerHTML;
    var vmbox = getParameter('vmbox');

    $.ajax({
        type: "POST",
        url: "/controller/gmail/nav_mail_cnt.php",
        dataType: "JSON",
        data: JSON.stringify({"mem_nickname": mem_nickname, "vmbox": vmbox}),
        success: function (data) {
            $(".unseen_cnt").html(data.unseen_cnt);
            $(".total_cnt").html(data.total_cnt);

        }, error: function (a, b, c) {
            console.log(c);
        }
    });
}

function get_mbox() {
    var type = "";
    var type_title = "";

    if (typeof (getParameter("vmbox")) != "undefined" && getParameter("vmbox") !== null) {
        type = getParameter("vmbox");

        if (type == 0 || type == "") {
            type_title = "<i class='fa fa-envelope-o'></i> 받은 메일함";
            $("[name='loc_not_trash']").css('display', 'inline-block');
            $("[name='loc_not_spam']").css('display', 'inline-block');
            $("[name='loc_trash']").css('display', 'none');
            $("[name='loc_spam']").css('display', 'none');
        } else if (type == 4) {
            type_title = "<i class='fa fa-ban'></i> 스팸 메일함";
            $("[name='loc_not_trash']").css('display', 'inline-block');
            $("[name='loc_not_spam']").css('display', 'none');
            $("[name='loc_trash']").css('display', 'none');
            $("[name='loc_spam']").css('display', 'inline-block');
        } else if (type == 3) {
            type_title = "<i class='fa fa-star'></i> 중요 메일함";
            $("[name='loc_not_trash']").css('display', 'inline-block');
            $("[name='loc_not_spam']").css('display', 'inline-block');
            $("[name='loc_trash']").css('display', 'none');
            $("[name='loc_spam']").css('display', 'none');
        } else if (type == 5) {
            type_title = "<i class='fa fa-trash'></i> 휴지통";
            $("[name='loc_not_trash']").css('display', 'none');
            $("[name='loc_not_spam']").css('display', 'inline-block');
            $("[name='loc_trash']").css('display', 'inline-block');
            $("[name='loc_spam']").css('display', 'none');
            $(".loc_trash").css('display', 'none');
        } else if (type == 1) {
            type_title = "<i class='fa fa-paper-plane' aria-hidden='true'></i> 보낸메일함";
            $(".loc_receive").css('display', 'none');
        } else if (type == 2) {
            type_title = "<i class='fa fa-file-text-o' aria-hidden='true'></i> 내게쓴 메일함";
            $(".loc_receive").css('display', 'none');
        }
    } else if (typeof (getParameter("stype")) != "undefined" && getParameter("stype") !== null) {
        type = getParameter("stype");
        if (type == "new") {
            type_title = "<i class='fa fa-pencil-square-o' aria-hidden='true'></i> 메일쓰기"
            $(".loc_not_me").css("display", "position");
        } else if (type == "me") {
            type_title = "<i class='fa fa-reply' aria-hidden='true'></i> 내게쓰기"
            $(".loc_not_me").css("display", "none");
        } else if (type == "reply") {
            type_title = "<i class='fa fa-reply' aria-hidden='true'></i> 답장하기"
            $(".loc_not_me").css("display", "position");
        }
    }

    $(".box_title").append(type_title);
}

function update_btn(column, value, gmno) {
    //column : gm_seen, gm_mbox
    //value : 현재값
    //gmno : 메일번호

    value = (1 == value) ? 0 : 1;

    var param = {};
    param['gmno'] = gmno;
    param[column] = String(value);
    param = JSON.stringify(param);

    $.ajax({
        type: "POST",
        url: "/controller/gmail/update_mail.php",
        dataType: "json",
        data: param,
        success: function (data) {
            if (data.state == 200) {
                location.reload();
            } else {
                console.log(data.message);
            }
        }, error: function (a, b, c) {
            console.log(c);
        }
    });
}

function move_mbox() {
    var vmbox = $("#move_mbox").val();
    var column = '';
    var type = 1;

    switch (vmbox) {
        case '0' :
            column = "gm_mbox";
            type = "0";
            break;
        case '3' :
            column = "gm_star";
            break;
        case '4' :
            column = "gm_mbox";
            break;
        case '5' :
            column = "gm_deleted";
            break;
    }

    if (type == "") {
        alert("이동할 메일함을 선택하세요.");
    } else {
        update_chkbox(column, type);
    }
}


function update_chkbox(column, type) {
    var url = location.href;
    var count = $("input[name='chk']:checked").length;
    var view_gmno = getParameter('gmno');
    if (count > 0 || view_gmno) {
        var gmno = '';
        if (count == 1) {
            gmno = $("input[name='chk']:checked").attr('id');
        } else if (view_gmno) {
            gmno = view_gmno;
        } else {

            var gmno = new Array;
            $("input[name='chk']:checked").each(function () {
                var gm_idx = $(this).attr('id');
                gmno.push(gm_idx);
            });
        }

        var param = {};
        param['gmno'] = gmno;
        param[column] = String(type);
        param = JSON.stringify(param);

        var cnf_msg;
        if (column == "gm_deleted" && type == 1) {
            cnf_msg = "삭제 하시겠습니까?";
        } else if (column == "gm_mbox" && type == 1) {
            cnf_msg = "스팸차단 하시겠습니까?";
        }
        if (column == "gm_deleted" && type == 1 || column == "gm_mbox" && type == 1) {
            if (confirm(cnf_msg)) {
                update_func(param);
            }

        } else {
            update_func(param);
        }

    } else {
        alert("메일을 선택하세요.");
    }
}

function update_func(param) {
    $.ajax({
        type: "POST",
        url: "/controller/gmail/update_mail.php",
        dataType: "json",
        data: param,
        success: function (data) {
            if (data.state == 200) {
                if (getParameter('gmno')) {
                    history.back();
                } else {
                    location.reload();
                }
            } else {
                console.log(data.message);
            }
        }, error: function (a, b, c) {
            console.log(c);
        }
    });
}

function reply_mail() {
    var gm_to = $(".from").html();
    gm_to = gm_to.split("&lt;")[1];
    gm_to = gm_to.split("&gt;")[0];
    location.href = '/view/mail/gmail_send.php?stype=reply&gm_to=' + gm_to + '&gm_title=' + $(".subject").html();
}

function isView() {
    var url_arr = window.location.pathname.split("/");
    var view_url = url_arr[url_arr.length - 1];
    if (view_url == "gmail_view.php") {
        $("#chkall").css('display', 'none');
    }
}
