$(function () {
    $.ajax({
        type: "GET",
        url: "/controller/member/access.php",
        success: function (data) {
            if (data == "") {
                console.log("hj");
                location.href = "/view/mail/gmail.php?vmbox=0";
            }
        }, error: function (a, b, c) {
            console.log(c);
        }
    });
});

function login() {
    var mem_id = $("[name='mem_id']").val();
    var mem_password = $("[name='mem_password']").val();

    if (mem_id != "" && mem_password != "") {
        $.ajax({
            type: "POST",
            dataType: "json",
            data: JSON.stringify({
                "mem_id": mem_id,
                "mem_password": mem_password
            }),
            url: "/controller/member/login.php",
            success: function (data) {
                if (data.state == 200) {
                    location.href = "/view/mail/gmail.php?vmbox=0";
                } else if (data.state == 403) {
                    alert("관리자가 아닙니다.");
                } else if (data.state == 400) {
                    alert("아이디 혹은 비밀번호가 틀렸습니다.");
                } else if (data.state == 500) {
                    alert("Internal Server Error");
                }
            }
        });
    } else {
        alert("빈 값을 확인해주세요.");
    }
}

