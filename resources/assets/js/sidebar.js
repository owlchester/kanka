$(document).ready(function () {
    registerSidebarEvents();
});


/**
 *
 */
function registerSidebarEvents() {
    let toggler = $('.sidebar-campaign .campaign-head .campaign-name');
    if (toggler.length === 0) {
        return;
    }

    let down = $('.sidebar-campaign .campaign-head .campaign-name .fa-caret-down');
    let dropdown = $('#campaign-switcher');
    let backdrop = $('.campaign-switcher-backdrop');

    toggler.on('click', function(e) {
        e.preventDefault();
        dropdown.collapse('toggle');
        backdrop.show();
        down.addClass('flipped');
    });

    backdrop.click(function (e) {
        e.preventDefault();
        backdrop.hide();
        dropdown.collapse('hide');
        down.removeClass('flipped');
    });
}
