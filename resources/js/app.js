import './tags.js';
import './components/select2.js';
import Coloris from "@melloware/coloris";
import dynamicMentions from "./mention";

import.meta.glob([
    '../images/**',
]);

$(document).ready(function() {
    initPageHeight();

    window.initForeignSelect();
    window.initDialogs();
    initColourPicker();
    initSubmenuSwitcher();

    manageTabs();

    dynamicMentions();
    initAjaxPagination();
    initDynamicDelete();
    initImageRemoval();
    initFeedbackButtons();
    initDismissible();
    initAdblocker();

    /**
     * Whenever a modal or popover is shown, we'll need to re-bind various helpers we have.
     */
    $(document).on('shown.bs.modal', function() {
        // Also re-bind select2 elements on modal show
        window.initForeignSelect();
        window.initTags();
        window.initDialogs();
        window.initTooltips();
        window.ajaxTooltip();
        window.initDropdowns();
        window.initSortable();
        initAjaxPagination();
        initColourPicker();
        initDynamicDelete();
        initImageRemoval();
        initFeedbackButtons();
        initDismissible();
        initPermBtn();
    });
});

function initAdblocker() {
    let adscript = document.getElementById('ad-client');
    if (!adscript) {
        return;
    }
    fetch(adscript.src, {
        // headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .catch(() => {
        let reminder = document.getElementById('adblock-plea');
        if (!reminder) {
            return;
        }
        reminder.classList.remove('hidden');
    });
}

/**
 * Initiate color for the various fields
 */
function initColourPicker() {

    Coloris.init();
    Coloris({
        el: '.spectrum',
        format: 'hex',
        alpha: false,
        theme: 'pill',
        clearButton: true,
        closeButton: true,
    });

    document.querySelectorAll('.spectrum').forEach(input => {
        if (input.dataset.init === "1") {
            return;
        }
        input.dataset.init = 1;
        input.addEventListener('click', function (e) {
            Coloris({
                parent: input.dataset.appendTo ?? '.container',
            });
        });
        // Don't close the dialog backdrop
        input.addEventListener('close', e => {
            e.stopPropagation();
        });
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
        let nohash = $(e.target).data("nohash");

        if (nohash) {
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
    $.each($('[data-img="delete"]'), function () {
        $(this).unbind('click').click(function (e) {
            e.preventDefault();
            $('input[name=' + $(this).data('target') + ']')[0].value = 1;
            $(this).closest('.preview').hide();
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

        fetch($(this).attr('href'))
            .then(response => response.text())
            .then(response => {
                paginationAjaxBody.parent().html(response);
                initAjaxPagination();
                $(document).trigger('shown.bs.modal');
            });
        return false;
    });
}

/**
 * Popover delete confirmation with button, rather than a modal. Used for displaying a confirmation
 * in a modal.
 */
function initDynamicDelete() {
    $('[data-toggle="confirm-delete"]').unbind('click').on('click', function (e) {
        e.preventDefault();
        if ($(this).data('confirming') === 1) {
            $(this).addClass('loading');
            $(this).html('');
            let target = $(this).data('target');
            if ($(target).length === 0) {
                console.error('Unknown target', target);
            } else {
                $(target).submit();
            }

            return;
        }

        $(this).data('confirming', 1);
        $(this).find('span').addClass('md:inline');
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
    const quickPrivacy = document.getElementById('quick-privacy-select');
    if (quickPrivacy) {
        quickPrivacy.addEventListener('change', function () {
            const toggleUrl = this.dataset.url;

            axios
                .post(toggleUrl)
                .then(response => {
                    window.showToast(response.data.toast);
                    let body = document.querySelector('body');
                    if (response.data.status) {
                        body.classList.add('kanka-entity-private');
                    } else {
                        body.classList.remove('kanka-entity-private');
                    }
                });
        });
    }
};

const initDismissible = () => {
    const elements = document.querySelectorAll('[data-dismisses]');
    elements.forEach(el => {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            let target = document.querySelector(this.dataset.dismisses);
            target.classList.remove('opacity-100');
            target.classList.add('opacity-0');

            setTimeout(function () {
                target.remove();
            }, 150);
        });
    });
};

const initPermBtn = () => {
    const btn = document.querySelector('.btn-manage-perm');
    if (!btn) {
        return;
    }
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        window.closeDialog('primary-dialog');
        let permTarget = btn.dataset.target;
        document.querySelector(permTarget).click();
    });
};

// Splitting off the js files into logical blocks
import './keyboard';
import './crud';
import './entities';
import './post';
import './post-layouts';
import './calendar';
import './forms/calendar-date';
import './keep-alive';
import './quick-creator';
import './datagrids';
import './animations';
import './quick-links';
import './webhooks';
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
import './togglers';

// VueJS elements
//import './navigation');
import './header';
//import './ads');
import './utility/tippy';
import './maintenance';
