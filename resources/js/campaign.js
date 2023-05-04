import Sortable from "sortablejs";

$(document).ready(function() {
    initRpgSystems();
    registerModules();
    registerUserRoles();
    registerCodeMirror();
    registerSidebarSetup();
    registerCampaignExport();
    registerRoles();
    registerCampaignThemes();
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
    if ($('#campaign-modules').length === 0) {
        return;
    }
    $('input[name="enabled"]').change(function (e) {
        e.preventDefault();
        let header = $(this).closest('.box-module').find('h3');
        if (header.hasClass('loading')) {
            return;
        }
        header.addClass('loading');

        $.ajax({
            method: 'post',
            url: $(this).data('url'),
            context: this,
        }).done(function (res) {
            if (res.success) {
                if (res.status) {
                    $(this).closest('.box-module').addClass('module-enabled');
                } else {
                    $(this).closest('.box-module').removeClass('module-enabled');
                }

                window.showToast(res.toast);
            }
            $(this).closest('.box-module').find('h3').removeClass('loading');
        });
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

/** Toggling an action on a permission **/
function registerRoles() {
    $('.public-permission').click(function (e) {
        e.preventDefault();
        $(this).addClass('loading');

        $.ajax({
            method: 'post',
            url: $(this).data('url'),
            context: this,
        }).done(function (res) {
            $(this).removeClass('loading');
            if (res.success) {
                if (res.status) {
                    $(this).addClass('enabled');
                } else {
                    $(this).removeClass('enabled');
                }
                window.showToast(res.toast);
            }
        });

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
    let nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));

    // Loop through each nested sortable element
    for (let i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            handle: '.dnd-handle',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,

            // Attempt to drag a filtered element
            onMove: function (/**Event*/evt, /**Event*/originalEvent) {
                let self = evt.dragged;
                let target = evt.related;
                // Couldn't figure out how to do this in pure js, so falling back on jQuery
                let targetParentIsFixed = $(target).parents('.fixed-position').length > 0;
                if (self.classList.contains('fixed-position') && targetParentIsFixed) {
                    return false;
                }
                return true;
            },
        });
    }
}

function registerCampaignExport() {
    let exportBtn = $('.campaign-export-btn');
    if (exportBtn.length === 0) {
        return;
    }

    exportBtn.click(function (e) {
        e.preventDefault();
        $(this).addClass('loading');

        $.ajax({
            url: exportBtn.data('url'),
            method: 'POST',
            context: this,
        }).done (function (res) {
            $(this).removeClass('loading').hide();
            if (res.error) {
                window.showToast(res.error, 'toast-error');
            } else {
                window.showToast(res.success);
            }
        }).fail (function (res) {
            console.error('campaign export call', res);
        });
    });
}

/**
 * Register events for campaign themes, notably the max size of a css field
 */
function registerCampaignThemes() {
    let forms = $('form#campaign-style');
    if (forms.length === 0) {
        return;
    }

    forms.on('submit', function (e) {
        let error = $($(this).data('error'));
        let length = $('textarea[name="content"]').val().length;
        if (length < $(this).data('max-content')) {
            error.hide();
            return true;
        }

        // Show a custom error message to the user
        error.show();

        $('form .submit-group .btn').prop('disabled', false);

        return false;
    });
}
