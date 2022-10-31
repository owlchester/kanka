import Sortable from "sortablejs";

$(document).ready(function() {
    initRpgSystems();
    registerModules();
    registerUserRoles();
    registerCodeMirror();
    registerSidebarSetup();
    registerCampaignExport();
    registerRoles();
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
    if ($('.campaign-settings').length === 0) {
        return;
    }
    $('.box-module').unbind('click').click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('box-loading')) {
            return;
        }
        $(this).addClass('box-loading');
        $(this).find('.loading').show();
        $(this).find('p').hide();

        $.ajax({
            method: 'post',
            url: $(this).data('url'),
            context: this,
        }).done(function (res) {
            if (res.success) {
                if (res.status) {
                    $(this).addClass('box-success').removeClass('box-default');
                } else {
                    $(this).removeClass('box-success').addClass('box-default');
                }

                window.showToast(res.toast);
            }

            $(this).find('.loading').hide();
            $(this).find('p').show();
            $(this).removeClass('box-loading');
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
                let targetParentIsFixed = $(target).parents('.fixed').length > 0;
                if (self.classList.contains('fixed') && targetParentIsFixed) {
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

    let spinner = $('.campaign-export-spinner');
    spinner.hide();
    exportBtn.show();

    exportBtn.click(function (e) {
        e.preventDefault();
        spinner.show();
        exportBtn.hide();

        $.ajax({
            url: exportBtn.data('url'),
            method: 'POST',
        }).done (function (res) {
            spinner.hide();
            if (res.error) {
                $('#campaign-export-error').html(res.error).show();
            } else {
                $('#campaign-export-success').html(res.success).show();
            }
        }).fail (function (res) {
            console.error('campaign export call', res);
        });
    });
}
