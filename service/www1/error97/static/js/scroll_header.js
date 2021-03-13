$(document).ready(function() {
    let did_scroll;
    let last_scrollTop = 0;
    let s_delta = 1;  // where does the job begin
    let frame_menu = $("#frame_menu").outerHeight();  // select which elements will be affected

    $(window).scroll(function(event) {
        did_scroll = true;
    });

    setInterval(function() {
        if(did_scroll) {
            hasScrolled();
            did_scroll = false;
        }
    }, 150);

    function hasScrolled() {
        let scroll_t = $(this).scrollTop();  // save the current scroll position
        if(Math.abs(last_scrollTop-scroll_t) <= s_delta) return;  // make sure that the scroll is greater than the s_delta value you set

        // check whether the scroll is more scrolled than the height of the menu_box and if the scroll is oriented up or down
        if(scroll_t > last_scrollTop && scroll_t > frame_menu) {
            // scroll down
            $("#frame_menu").removeClass("nav-down").addClass("nav-up");
            if($("html").scrollTop() >= 100) {
                $("#frame_menu").addClass("headFixed");
            }
        } else {
            // scroll up
            if(scroll_t + $(window).height() < $(document).height()) {
                $("#frame_menu").removeClass("nav-up").addClass("nav-down");
                if($("html").scrollTop() == 0) {
                    $("#frame_menu").removeClass('headFixed');
                } else {
                    $("#frame_menu").addClass('headFixed');
                }
            }
        }
        last_scrollTop = scroll_t;  // specify the current scroll location for last_scrollTop
    }
});