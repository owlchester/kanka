$(document).ready(function() {
    initRpgSystems();
    registerModules();
});

/**
 * Form Rpg Systems field
 */
function initRpgSystems() {
    $.each($('.form-rpg-systems'), function (index) {
        $(this).select2({
            multiple: true,
            allowClear: true,
            minimumInputLength: 0
        });
    });
}

/**
 * Register Modules change for campaign settings
 */
function registerModules() {
    $('.content :checkbox').change(function () {
        if (this.checked) {
            $(this).closest('div.box').removeClass('box-default').addClass('box-success');
        } else {
            $(this).closest('div.box').removeClass('box-success').addClass('box-default');
        }
    });
}