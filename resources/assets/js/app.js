/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import deleteConfirm from './components/delete-confirm.js';
import dynamicMentions from "./mention";

require('./tags.js');
require('./components/select2.js');

$(document).ready(function() {

    // Inject the isMobile variable into the window. We don't want ALL of the javascript
    // for mobiles, namely the tooltip tool.
    window.kankaIsMobile = window.matchMedia("only screen and (max-width: 760px)");
    if (!window.kankaIsMobile.matches) {
        initTooltips();
    }

    /*$('[data-toggle="popover"]').popover({
        sanitize: false,
    });*/

    window.initForeignSelect();
    initSpectrum();
    initSubmenuSwitcher()


    if ($('#delete-confirm-form').length > 0) {
        $('#delete-confirm-form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    }

    // Treeview for locations
    treeViewInit();

    manageTabs();

    deleteConfirm();
    dynamicMentions();
    initTogglePasswordFields();
    initAjaxPagination();
    initEntityNoteToggle();
    initDynamicDelete();
    initImageRemoval();

    /**
     * Whenever a modal or popover is shown, we'll need to re-bind various helpers we have.
     */
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        $('[data-toggle="tooltip"]').tooltip();

        // Also re-bind select2 elements on modal show
        window.initForeignSelect();
        window.initTags(); // Need this for the abilities popup on entities
        initAjaxPagination();
        initTooltips();
        initSpectrum();
        initDynamicDelete();
        initImageRemoval();
        deleteConfirm();
    });
});



/**
 * Initiate spectrum for the various fields
 */
function initSpectrum() {
    if (!$.isFunction($.fn.spectrum)) {
        return;
    }

    $.each($('.spectrum'), function (i) {
        $(this).spectrum({
            preferredFormat: "hex",
            showInput: true,
            showPalette: true,
            allowEmpty: true,
            appendTo: $(this).data('append-to') ?? null,
        });
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
                //console.log('click tr', target);
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

function initImageRemoval() {
    $.each($('.img-delete'), function (index) {
        $(this).unbind('click').click(function (e) {
            e.preventDefault();
            $('input[name=' + $(this).data('target') + ']')[0].value = 1;
            $(this).parent().parent().hide();
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


function initDynamicDelete() {
    $('.btn-dynamic-delete').popover({
        html: true,
        placement: 'top',
        sanitize: false
    });

    $('a[data-toggle="delete-form"]').unbind('click').click(function (e) {
        e.preventDefault;
        let target = $(this).data('target');
        //console.log('target', target);
        $(target).submit();
    });

    $('.btn-popover').popover({
        html: true,
        placement: 'bottom',
        sanitize: false,
        trigger: 'focus'
    })
}


function initSubmenuSwitcher() {
    $('.submenu-switcher').change(function (e) {
        e.preventDefault();
        console.log('this', $(this));

        let selected = $(this).find(":selected");
        let route = selected.data('route');
        console.log('route', route);

        window.location.href = route;
    });
}


/**
 * Entity Note toggle support
 */
function initEntityNoteToggle() {
    $('.entity-note-toggle').on('click', function() {
        let id = $(this).data('short');
        $('#' + id + "-show").toggle();
        $('#' + id + "-hide").toggle();
    });
}


// Splitting off the js files into logical blocks
require('./helpers')
require('./keyboard')
require('./crud')
require('./calendar')
require('./search')
require('./notification')
require('./quick-creator')
require('./tutorial')
require('./datagrids')
require('./quick-links')
require('./members')
require('./campaign')
require('./clipboard')
require('./toast')
require('./sidebar')
require('./banner')
require('./timeline')
require('./vendor')
require('./ads')
