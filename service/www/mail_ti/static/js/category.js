$(function () {
    menu();
});

function menu() {
    let menu = $('#cssmenu > ul');
    menu.find('.has-sub > ul').show();

    menu.on('click', function (event) {

        let targetParent = $(event.target).parent();
        if (targetParent.hasClass('has-sub')) {
            targetParent.toggleClass('active');
            targetParent.children('ul').slideToggle(250);
        }
    });
}
