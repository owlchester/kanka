$(document).ready(function() {
    initRpgSystems();
    registerModules();
    registerUserRoles();
    registerCodeMirror();
    registerSidebarSetup();
});

/**
 * Form Rpg Systems field
 */
function initRpgSystems() {
    $.each($('.form-rpg-systems'), function () {
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

/**
 * Initiate codemirror editor in the theming section
 */
function registerCodeMirror() {
    $.each($('.codemirror'), function () {
        let elementID = $(this).attr('id');
        CodeMirror.fromTextArea(document.getElementById(elementID), {
            extraKeys: {"Ctrl-Space": "autocomplete"},
            lineNumbers: true,
            lineWrapping: true,
            theme: 'dracula',
        });
    });
}

function registerSidebarSetup() {
    $('ul.sidebar-sortable').sortable({
        connectWith: 'ul.sidebar-sortable',
        placeholder: 'placeholder',
        //items: 'li:not(.fixed)',
        stop: function (e, ui) {
            if (ui.item.first().hasClass('fixed') && ui.item.parents('.fixed').length > 0) {
                $('ul.sidebar-sortable').sortable("cancel");
            }
        }
    });

    $('form.sidebar-setup').on('submit', function (e) {
        var sortedIDs = $('ul.sidebar-sortable').sortable( "toArray" );
        //console.log('sortedIDs', sortedIDs);

        return true;

    });
}
