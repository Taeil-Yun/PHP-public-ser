$(document).ready(function() {
    $("#mainImg_slide").slick({
        slidesToShow: 1,  // number of images displayed
        slidesToScroll: 1,  // image slide count
        autoplay: true,  // auto image slide
        autoplaySpeed: 5000,  // auto image slide to speed
        speed: 1000,  // moving speed
        dots: true,
        customPaging: function (slider, i) {
            return '<button type="button" role="tab" id="slick-slide-control00" aria-controls="slick-slide00" aria-label="1 of 3" tabindex="0" aria-selected="true">1<div class="dot"><div class="halfclip"><div class="halfcircle clipped" ></div></div><div class="halfcircle fixed"></div></div></button>';
        }
    });
});

// $(document).ready(function() {  // main image slide start
//     let banner = $(".main_topImg > article").find("ul");
//     let banner_width = banner.children().outerWidth();  // this is a width of elements
//     let rollingId;
//     let imgArr = 0;  // variable to add class
//
//     rollingId = setInterval(function() { rollingStart(); }, 4000);  // time to move on to next elements
//     $("#mainImg_slide").mouseover(function() {
//         clearInterval(rollingId);  // stop when the mouse cursor goes up
//     });
//     $("#mainImg_slide").mouseout(function() {  // restart
//         rollingId = setInterval(function() { rollingStart(); }, 4000);  // time to move on to next elements
//     });
//
//     function rollingStart() {
//         banner.animate({left : - banner_width + "px"}, 1000, function() {  // move banner to the left, number == speed
//             if(imgArr == 0) {
//                 // copy first elements and add it to end
//                 $(this).append("<li class='slideImg1'>" + $(this).find("li:first-child").html() + "</li>");
//                 imgArr = 1;
//             } else if(imgArr == 1) {
//                 // copy first elements and add it to end
//                 $(this).append("<li class='slideImg2'>" + $(this).find("li:first-child").html() + "</li>");
//                 imgArr = 2;
//             } else if(imgArr == 2) {
//                 // copy first elements and add it to end
//                 $(this).append("<li class='slideImg3'>" + $(this).find("li:first-child").html() + "</li>");
//                 imgArr = 0;
//             } else {}
//             $(this).find("li:first").remove();  // this a first elements copied to back not required so delete
//             $(this).css("left", 0);  // initialize the left position of the banner for the next movement
//         });
//     }
// });  // main image slide end