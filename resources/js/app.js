import './tags.js';
import './components/select2.js';

import deleteConfirm from './components/delete-confirm.js';
import dynamicMentions from "./mention";


$(document).ready(function() {
    initPageHeight();

    window.initForeignSelect();
    initSpectrum();
    initSubmenuSwitcher();

    let deleteConfirmForms = $('#delete-confirm-form');
    if (deleteConfirmForms.length > 0) {
        deleteConfirmForms.on('keyup keypress', function (e) {
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
    initAjaxPagination();
    initDynamicDelete();
    initImageRemoval();
    initFeedbackButtons();
    window.initDialogs();

    /**
     * Whenever a modal or popover is shown, we'll need to re-bind various helpers we have.
     */
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        // Also re-bind select2 elements on modal show
        window.initForeignSelect();
        window.initTags(); // Need this for the abilities popup on entities
        initAjaxPagination();
        initSpectrum();
        initDynamicDelete();
        initImageRemoval();
        deleteConfirm();
        initFeedbackButtons();
        window.initDialogs();
        window.initTooltips();
    });
});



/**
 * Initiate spectrum for the various fields
 */
function initSpectrum() {
    if (!$.isFunction($.fn.spectrum)) {
        return;
    }

    $.each($('.spectrum'), function () {
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
 * Go through table trs to add on click support
 */
function treeViewInit() {
    let treeViewLoader = $('.list-treeview');
    if (treeViewLoader.length === 0) {
        return;
    }

    let link = treeViewLoader.data('url');
    $.each($('.table-nested > tbody > tr'), function () {
        let children = $(this).data('children');
        if (parseInt(children) > 0) {
            $(this).addClass('tr-hover cursor-pointer');
            $(this).on('click', function (e) {
                let target = $(e.target);
                // Don't trigger the click on the checkbox (used for bulk actions)
                //console.log('click tr', target);
                if (e.target.type !== 'checkbox' && target.data('tree') !== 'escape') {
                    window.location = link + '?parent_id=' + $(this).data('id') + '&m=table';
                }
            });
        }
    });
}

/**
 * Save and manage tabs for when refreshing
 * Move this to crud or forms
 */
function manageTabs() {
    let tabLink = $('.nav-tabs li a');
    tabLink.click(function (e) {
        e.preventDefault();

        // If tab isn't ajax request
        if (!$(this).data('url')) {
            $(this).tab('show');
        }
    });

    // store the currently selected tab in the hash value
    tabLink.on("shown.bs.tab", function (e) {
        e.preventDefault();
        let tabId = $(e.target).attr("href").substr(1);
        let dataToggle = $(e.target).attr('ajax-modal');
        let nohash = $(e.target).data("nohash");

        if ((dataToggle && dataToggle === 'ajax-modal') || (nohash)) {
            // Modal? Don't do more.
            return true;
        }
        // We fake a tab_ to avoid page jumps from the browser
        window.location.hash = 'tab_' + tabId;
    });

    // on load of the page: switch to the currently selected tab
    let tabHash = window.location.hash.replace('tab_', '');
    $('ul.nav-tabs > li > a[href="' + tabHash + '"]').tab('show');
}

function initImageRemoval() {
    $.each($('.img-delete'), function () {
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
        let paginationAjaxBody = $('.pagination-ajax-body');
        paginationAjaxBody.find('.modal-loading').show();
        paginationAjaxBody.find('.pagination-ajax-content').hide();

        $.ajax({
                url: $(this).attr('href'),
                context: this,
        }).done(function (res) {
            paginationAjaxBody.parent().html(res);
            initAjaxPagination();
        });
        return false;
    });
}

/**
 * Popover delete confirmation with button, rather than a modal. Used for displaying a confirmation
 * in a modal.
 */
function initDynamicDelete() {
    $('[data-toggle="confirm-delete"]').on('click', function (e) {
        e.preventDefault();
        if ($(this).data('confirming') === 1) {
            $(this).addClass('loading');
            $(this).html('');
            let target = $(this).data('target');
            //console.log('target', target);
            $(target).submit();
            return;
        }

        $(this).data('confirming', 1);
        $(this).find('span').html($(this).data('confirm'));
    });

    $('a[data-toggle="delete-form"]').unbind('click').click(function (e) {
        e.preventDefault();
        let target = $(this).data('target');
        //console.log('target', target);
        $(target).submit();
    });
}


function initSubmenuSwitcher() {
    $('.submenu-switcher').change(function (e) {
        e.preventDefault();

        let selected = $(this).find(":selected");
        window.location.href = selected.data('route');
    });
}




/**
 * AdminLTE legacy. The CSS is a bit weird, for small pages we need to force a min-height
 * So that the footer is at the bottom, and so that the sidebar can be fully scrolled
 */
function initPageHeight() {
    let controlSidebar = 0;

    const heights = {
        window: $(window).height(),
        header: $('header').length > 0 ? $('header').outerHeight() : 0,
        footer: $('.main-footer').length > 0 ? $('.main-footer').outerHeight() : 0,
        sidebar: $('.main-sidebar .sidebar').length > 0 ? $('.main-sidebar .sidebar').height() : 0,
        controlSidebar
    };

    let max = heighestValue(heights);

    let $contentSelector = $('.content-wrapper');
    if (max === heights.controlSidebar) {
        $contentSelector.css('min-height', max);
    } else if (max === heights.window) {
        $contentSelector.css('min-height', (max - heights.header - heights.footer));
    } else {
        $contentSelector.css('min-height', (max - heights.header));
    }
}

function heighestValue(numbers) {
    // Calculate the maximum number in a list
    let max = 0;

    Object.keys(numbers).forEach(key => {
        if (numbers[key] > max) {
            max = numbers[key]
        }
    })

    return max;
}

/**
 * When clicking on these buttons, adds a "loading" spinner to indicate that something is happening
 */
const initFeedbackButtons = () => {
    document.querySelectorAll('.btn-feedback').forEach((el) => {
        let feedback = el.dataset.feedback;
        if (feedback) {
            return;
        }
        el.dataset.feedback = 1;
        el.addEventListener('click', (e) => {
            e.target.classList.add('loading');
        }, false);
    });

    // We should move this to a custom event handler?
    $('#quick-privacy-select').change(function () {
        let toggleUrl = $(this).data('url');

        $.ajax({
            url: toggleUrl,
            type: 'POST'
        }).done( function (success) {
            window.showToast(success.toast);
            if (!success.status) {
                $('body').addClass('kanka-entity-private');
            } else {
                $('body').removeClass('kanka-entity-private');
            }
            //target.close();
        });
    });
};

// Splitting off the js files into logical blocks
import './helpers';
import './keyboard';
import './crud';
import './post';
import './calendar';
import './keep-alive';
//import './search');
//import './notification');
import './quick-creator';
//import './tutorial')
import './datagrids';
import './quick-links';
import './post-layouts';
import './members';
import './campaign';
import './clipboard';
import './toast';
import './sidebar';
import './banner';
import './timelines';
import './utility/sortable';
import './utility/formError';
import './utility/dialog';

// VueJS elements
//import './navigation');
import './header';
//import './ads');
import './utility/tippy';
import './ajax-subforms';
