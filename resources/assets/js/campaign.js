$(document).ready(function() {
    initRpgSystems();
    registerModules();
    registerUserRoles();
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

/**
 * User role admin quick interface
 */
function registerUserRoles() {
    $('.btn-user-roles').popover({
        html: true,
        sanitize: false,
        trigger: 'focus',
    });
}
