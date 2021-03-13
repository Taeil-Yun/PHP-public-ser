$(document).ready(function() {
    if($(document).scrollTop() >= 500) {  // // when loaded
        $("#btn_move_top").css("visibility", "visible").css("opacity", "1");
    } else {
        $("#btn_move_top").css("visibility", "hidden").css("opacity", "0");
    }

    $(document).on("mousewheel", function() {  // when it started to mouse event
        if($(document).scrollTop() >= 500) {
            $("#btn_move_top").css("visibility", "visible").css("opacity", "1").css("transition", "all 0.3s linear");
        } else {
            $("#btn_move_top").css("visibility", "hidden").css("opacity", "0").css("transition", "all 0.3s linear");
        }
    });

    $("#btn_move_top").on("click", function() {  // when you click on it
        $("html, body").animate({scrollTop: 0}, 500);
        setTimeout(function() {
            $("#btn_move_top").css("visibility", "hidden").css("opacity", "0").css("transition", "all 0.3s linear");
        },550);
    });
});