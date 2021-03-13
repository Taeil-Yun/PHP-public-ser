function cheat() {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/controller/member/cheatLogin.php",
        success: function (data) {
            if (data.state == 200) {
                alert(data.message);
                location.href = '/';
            } else if (data.state == 201) {
                alert(data.message);
                location.reload();
            }
        }
    });
}