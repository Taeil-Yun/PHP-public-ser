$(function () {

    var state = getParameter('state');

    if (state == 'success') {
        $(".state_success").css('display', "block");
        $(".state_fail").css('display', "none");
        state_success();

    } else if (state == "fail") {
        $(".state_success").css('display', "none");
        $(".state_fail").css('display', "block");
        state_fail();

    } else {
        $(".state_success").css('display', "none");
        $(".state_fail").css('display', "none");
    }
});

// 성공시 이동코드
function state_success() {
    setTimeout(function () {
        $('.success_plane').animate({left: '720px', bottom: '350px'}, 1800);
    });
}

function state_fail() {
    // 실패시 이동코드
    setTimeout(function () {
        $('.fail_plane').animate({left: '760px', bottom: '350px'}, 250, function () {
            $(this).animate({left: '95%', bottom: 0}, 700, function () {
                $(this).css('transform', 'rotate(0deg)').css('background-image', 'url("/static/img/boom.png")');
            }).css('transform', 'rotate(90deg)');
        });
    });
}