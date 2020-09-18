/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import select2 from './components/select2.js';
import deleteConfirm from './components/delete-confirm.js';

$(document).ready(function() {

    // Inject the isMobile variable into the window. We don't want ALL of the javascript
    // for mobiles, namely the tooltip tool.
    window.kankaIsMobile = window.matchMedia("only screen and (max-width: 760px)");
    if (!window.kankaIsMobile.matches) {
        initTooltips();
    }

    $('[data-toggle="popover"]').popover({
        sanitize: false,
    });


    initSelect2();
    initSpectrum();
    initCheckboxSwitch();
    initCopyToClipboard();
    initSidebar();

    // Open select2 dropdowns on focus. Don't add this in initSelect2 since we only need this
    // binded once.
    $(document).on('focus', '.select2.select2-container', function (e) {
        // only open on original attempt - close focus event should not fire open
        if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
            $(this).siblings('select').select2('open');
        }
    });

    if ($('.date-picker').length > 0) {
        $.each($('.date-picker'), function (index) {
            // instance, using default configuration.
            $(this).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });
        });
    }

    if ($('.datetime-picker').length > 0) {
        $.each($('.datetime-picker'), function (index) {
            // instance, using default configuration.
            $(this).datetimepicker({
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm:00'
            });
        });
    }

    $.each($('.img-delete'), function (index) {
        $(this).click(function (e) {
            e.preventDefault();
            $('input[name=' + $(this).data('target') + ']')[0].value = 1;
            $(this).parent().parent().hide();
        });
    });


    if ($('#delete-confirm-form').length > 0) {
        $('#delete-confirm-form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    }

    $.each($('.new-entity-selector'), function (index) {
        $(this).on('click', function (e) {
            $('#new-entity-type').val($(this).data('entity'));
            $('#new-entity-form').data('parent', $(this).data('parent'));
        });
    });

    if ($('#new-entity-form').length > 0) {
        $('#new-entity-form').on('submit', function (e) {
            $('#new-entity-errors').hide();
            var target = $(this).data('parent');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize()
            }).done(function (result, textStatus, xhr) {
                if (textStatus === 'success' && result.id) {
                    $('#' + target).children().remove().end().append(new Option(result.name, result.id)).val(result.id).trigger('change');

                    // Close modal
                    $('#new-entity-modal').modal('toggle');
                    $('#new-entity-errors').hide();
                    $('#new-entity-name').val('');

                    // Reset submit button
                    resetSubmitButton('#new-entity-save');
                } else {
                    $('#new-entity-errors').show();

                    // Reset submit button
                    resetSubmitButton('#new-entity-save');
                }
            }).fail(function (result, textStatus, xhr) {
                $('#new-entity-errors').show();

                // Re-enable the submit button
                resetSubmitButton('#new-entity-save');
            });

            e.preventDefault();
            return false;
        });
    }


    // Treeview for locations
    treeViewInit();

    manageTabs();
    manageDashboardNotifications();


    // Live search on forms
    /*$.each($('.datagrid-search'), function(index) {
        $(this).submit(function(event) {
            event.preventDefault();

            window.location.href =
        });
    });*/

    deleteConfirm();
    initTogglePasswordFields();
    initAjaxPagination();
    initTimelineToggle();

    /**
     * Whenever a modal or popover is shown, we'll need to re-bind various helpers we have.
     */
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        $('[data-toggle="tooltip"]').tooltip();

        // Also re-bind select2 elements on modal show
        initSelect2();
        initCheckboxSwitch();
        initAjaxPagination();
        initTooltips();
        initCategories();
        initSpectrum();

        // Handle when opening the entity-creator ui
        entityCreatorUI();
    });
});

/**
 * Init the toggle elements
 */
function initCheckboxSwitch() {
    //$('[data-toggle="switch"]').bootstrapSwitch();
}

/**
 * Select2 is used for all the fancy dropdowns
 */
function initSelect2() {
    select2();
}


/**
 * Go through table trs to add on click support
 */
function treeViewInit() {
    var treeViewLoader = $('.list-treeview');
    if (treeViewLoader.length === 0) {
        return;
    }

    var link = treeViewLoader.data('url');
    $.each($('.table-nested > tbody > tr'), function(index) {
        var children = $(this).data('children');
        if (parseInt(children) > 0) {
            $(this).addClass('tr-hover');
            $(this).on('click', function (e) {
                let target = $(e.target);
                // Don't trigger the click on the checkbox (used for bulk actions)
                console.log('click tr', target);
                if (e.target.type !== 'checkbox' && target.data('tree') !== 'escape') {
                    window.location = link + '?parent_id=' + $(this).data('id');
                }
            });
        }
    });
}

/**
 * Save and manage tabs for when refreshing
 */
function manageTabs() {
    var tabLink = $('.nav-tabs li a');
    tabLink.click(function(e) {
        e.preventDefault();

        // If tab isn't ajax request
        if (!$(this).data('url')) {
            $(this).tab('show');
        }
    });

    // store the currently selected tab in the hash value
    tabLink.on("shown.bs.tab", function(e) {
        e.preventDefault();
        var tabId = $(e.target).attr("href").substr(1);
        var dataToggle = $(e.target).attr('ajax-modal');
        var nohash = $(e.target).data("nohash");

        if ((dataToggle && dataToggle == 'ajax-modal') || (nohash)) {
            // Modal? Don't do more.
            return true;
        }
        // We fake a tab_ to avoid page jumps from the browser
        window.location.hash = 'tab_' + tabId;
    });

    // on load of the page: switch to the currently selected tab
    var tabHash = window.location.hash.replace('tab_', '');
    $('ul.nav-tabs > li > a[href="' + tabHash + '"]').tab('show');
}

/**
 *
 */
function manageDashboardNotifications() {
    $.each($('.click-notification'), function(index) {
        $(this).modal();
    });

    $.each($('.notification-delete'), function(index) {
        $(this).on('click', function() {
            $.ajax({
                url: $(this).data('url'),
                dataType: 'json'
            });

            // Had this in the done, but it never fired?
            var parent = $(this).data('parent');
            $('#' + parent).modal('toggle');
        });

    });
}


/**
 * Show/Hide password field helpers
 */
function initTogglePasswordFields() {
    var passwordField = $('#password');
    var passwordToggleIcon = $('.toggle-password-icon');
    $('.toggle-password').on('click', function(e) {
        e.preventDefault();
        if (passwordField.prop('type') === 'text') {
            passwordField.prop('type', 'password');
            passwordToggleIcon.removeClass('fa-eye-slash').addClass('fa-eye')
        } else {
            passwordField.prop('type', 'text');
            passwordToggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
        return false;
    });
}

function resetSubmitButton(id) {
    var newEntitySaveButton = $(id);
    newEntitySaveButton.text(newEntitySaveButton.data('text')).prop('disabled', false);
}

/**
 * Quick Entity Creator UI
 */
function entityCreatorUI() {
    $('[data-toggle="entity-creator"]').on('click', function(e) {
        e.preventDefault();

        var entityCreatorSelection = $('#entity-creator-selection');
        var entityCreatorLoader = $('.entity-creator-loader');
        var entityCreatorFormPanel = $('.entity-creator-form-panel');

        entityCreatorSelection.addClass('hidden');
        entityCreatorLoader.removeClass('hidden');

        $.ajax($(this).data('url')).done(function (data) {
            entityCreatorLoader.addClass('hidden');
            entityCreatorFormPanel.html(data).removeClass('hidden');
            initSelect2();
            initEntityCreatorDuplicateName();
            window.initCategories();

            // Back button
            $('#entity-creator-back').on('click', function(e) {
                entityCreatorFormPanel.html('').addClass('hidden');
                entityCreatorSelection.removeClass('hidden');
                $('#entity-creator-form').hide();
            });

            $('#entity-creator-form').on('submit', function(e) {
                e.preventDefault();

                // Allow ajax requests to use the X_CSRF_TOKEN for deletes
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.post({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    context: this
                }).done(function (result, textStatus, xhr) {
                    // New entity was created, let's follow that redirect
                    //console.log(result);

                    entityCreatorFormPanel.html('').addClass('hidden');
                    entityCreatorSelection.removeClass('hidden');
                    $('#entity-creator-form').hide();
                    $('.entity-creator-success').html(result.message).show();

                }).fail(function (data) {
                    $('.entity-creator-error').show();
                });
            });
        });

        return false;
    });
}

function initEntityCreatorDuplicateName() {
    $('#entity-creator-form input[name="name"]').focusout(function(e) {
        // Don't bother if the user didn't set any value
        if (!$(this).val()) {
            return;
        }
        var entityCreatorDuplicateWarning = $('#entity-creator-form .duplicate-entity-warning');
        entityCreatorDuplicateWarning.hide();
        // Check if an entity of the same type already exists, and warn when it does.
        $.ajax(
            $(this).data('live') + '?q=' + $(this).val() + '&type=' + $(this).data('type')
        ).done(function (res) {
            if (res.length > 0) {
                let entities = Object.keys(res).map(function (k) { return '<a href="' + res[k].url + '">' + res[k].name + '</a>'}).join(', ');
                $('#entity-creator-form #duplicate-entities').html(entities);
                entityCreatorDuplicateWarning.fadeIn();
            } else {
                entityCreatorDuplicateWarning.hide();
            }
        });
    });
}

/**
 * Replace pagination for ajax links
 */
function initAjaxPagination() {
    $('.pagination-ajax-links a').on('click', function(e) {
        e.preventDefault();
        var paginationAjaxBody = $('.pagination-ajax-body');
        paginationAjaxBody.find('.loading').show();
        paginationAjaxBody.find('.pagination-ajax-content').hide();

        $.ajax(
            $(this).attr('href')
        ).done(function (res) {
            paginationAjaxBody.parent().html(res);
            initAjaxPagination();
        });
        return false;
    })
}

/**
 * Handler for copying content to the clipboard
 */
function initCopyToClipboard() {
    $('[data-clipboard]').click(function (e) {
        e.preventDefault();
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).data('clipboard')).select();
        document.execCommand("copy");
        $temp.remove();

        var post = $(this).data('success');
        if (post) {
            $(post).fadeIn();
            setTimeout(function() {
                console.log('post', post);
                $(post).fadeOut();
            }, 3000);
        }
    });
}

/**
 * Register the tooltip and tooltip-ajax helper
 */
function initTooltips() {
    $('[data-toggle="tooltip"]').tooltip();
    window.ajaxTooltip();
}

/**
 * Initiate spectrum for the various fields
 */
function initSpectrum() {
    if (!$.isFunction($.fn.spectrum)) {
        return;
    }
    $(".spectrum").spectrum({
        preferredFormat: "hex",
        showInput: true,
        showPalette: true,
        allowEmpty: true
    });
}

/**
 *
 */
function initSidebar() {
    let toggler = $('.sidebar-campaign .campaign-head .campaign-name');
    if (toggler.length === 0) {
        return;
    }

    let down = $('.sidebar-campaign .campaign-head .campaign-name .fa-caret-down');

    toggler.on('click', function(e) {
        e.preventDefault();
        if (down.hasClass('flipped')) {
            down.removeClass('flipped');
        } else {
            down.addClass('flipped');
        }
    });
}

/**
 * Timeline toggle support
 */
function initTimelineToggle() {
    $('.timeline-toggle').on('click', function() {
        let id = $(this).data('short');
        $('#' + id + "-show").toggle();
        $('#' + id + "-hide").toggle();
    });

    $('.timeline-era-reorder').on('click', function(e) {
        e.preventDefault();
        let eraId = $(this).data('era-id');

        $('#era-items-' + eraId + '').sortable();

        $(this).parent().hide();
        $('#era-items-' + eraId + '-save-reorder').show();
    });
}

// Helpers are injected directly in the window functions.
require('./helpers.js');

require('./keyboard.js');
require('./crud.js');
require('./calendar.js');
require('./search.js');
require('./tags.js');
require('./notification');
