import './events';
import './tags';
import './components/select2.js';
import Coloris from "@melloware/coloris";
import dynamicMentions from "./mention";

import.meta.glob([
    '../images/**',
]);

/**
 * Whenever a modal or popover is shown, we'll need to re-bind various helpers we have.
 */
window.onEvent(function() {
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
const manageTabs = () => {
    const tabs = document.querySelectorAll('.nav-tabs li a');
    tabs?.forEach(function (tab) {
        tab.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = tab.closest('.nav-tabs-custom');

            // Disable all but this tab
            parent.querySelectorAll('.nav-tabs li').forEach(function (subtab) {
                subtab.classList.remove('active');
            });
            tab.parentNode.classList.add('active');

            // Disable all but this panel
            parent.querySelectorAll('.tab-pane').forEach(function (subtab) {
                subtab.classList.remove('active');
            });

            const target = document.querySelector(tab.getAttribute('href'));
            target.classList.add('active');
        });
    });
}

const initImageRemoval = () => {
    document.querySelectorAll('[data-img="delete"]')?.forEach(function (preview) {
        preview.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('input[name=' + preview.dataset.target + ']').value = 1;
            preview.closest('.preview').classList.add('hidden');
        });
    });
};

/**
 * Replace pagination for ajax links
 */
const initAjaxPagination = () => {
    document.querySelectorAll('.pagination-ajax-links a').forEach(function (link) {
        if (link.dataset.loaded === '1') {
            return
        }
        link.dataset.loaded = '1';
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const paginationAjaxBody = document.querySelector('.pagination-ajax-body');
            paginationAjaxBody.querySelector('.modal-loading').classList.remove('hidden');
            paginationAjaxBody.querySelector('.pagination-ajax-content').classList.add('hidden');

            fetch(link.getAttribute('href'))
                .then(response => response.text())
                .then(response => {
                    paginationAjaxBody.parentNode.innerHTML = response;
                    initAjaxPagination();
                    window.triggerEvent();
                });
        });
    });
};

/**
 * Popover delete confirmation with button, rather than a modal. Used for displaying a confirmation
 * in a modal.
 */
const initDynamicDelete = () => {
    document.querySelectorAll('[data-toggle="confirm-delete"]')?.forEach(function (ele) {
        if (ele.dataset.loaded === '1') {
            return;
        }
        ele.dataset.loaded = '1';
        ele.addEventListener('click', function (e) {
            e.preventDefault();
            if (ele.dataset.confirming === '1') {
                ele.classList.add('loading');
                ele.innerHTML = ''
                const target = document.querySelector(ele.dataset.target);
                if (!target) {
                    console.error('Unknown target', target);
                } else {
                    target.requestSubmit();
                }

                return;
            }

            ele.dataset.confirming = '1';
            ele.querySelector('span').classList.add('md:inline');
            ele.querySelector('span').innerHTML = ele.dataset.confirm;
        });
    });
    document.querySelectorAll('a[data-toggle="delete-form"]')?.forEach(function (ele) {
        if (ele.dataset.loaded === '1') {
            return;
        }
        ele.dataset.loaded = '1';
        ele.addEventListener('click', function (e) {
            e.preventDefault();

            const target = document.querySelector(ele.dataset.target);
            target.requestSubmit();
        });
    });
};


const initSubmenuSwitcher = () => {
    document.querySelector('.submenu-switcher')?.addEventListener('change', function (e) {
        e.preventDefault();
        const ele = e.target;
        const selected = ele.options[ele.selectedIndex];
        window.location.href = selected.dataset.route;
    });
};

/**
 * AdminLTE legacy. The CSS is a bit weird, for small pages we need to force a min-height
 * So that the footer is at the bottom, and so that the sidebar can be fully scrolled
 */
const initPageHeight = () => {
    let controlSidebar = 0;

    const heights = {
        window: window.innerHeight,
        header: document.querySelector('header') ? outerHeight(document.querySelector('header')) : 0,
        footer: document.querySelector('.main-footer') ? outerHeight(document.querySelector('.main-footer')) : 0,
        sidebar: document.querySelector('.main-sidebar .sidebar') ? outerHeight(document.querySelector('.main-sidebar .sidebar')) : 0,
        controlSidebar
    };

    const max = heighestValue(heights);

    const $contentSelector = document.querySelector('.content-wrapper');
    if (max === heights.controlSidebar) {
        $contentSelector.style.minHeight = max;
    } else if (max === heights.window) {
        $contentSelector.style.minHeight = (max - heights.header - heights.footer);
    } else {
        $contentSelector.style.minHeight = (max - heights.header);
    }
};

const outerHeight = (el, includeMargin = false) => {
    // Get the height of the element including padding
    let height = el.getBoundingClientRect().height;

    // Optionally include the margin
    if (includeMargin) {
        const style = getComputedStyle(el);
        height += parseInt(style.marginTop) + parseInt(style.marginBottom);
    }

    return height;
};

const heighestValue = (numbers) => {
    // Calculate the maximum number in a list
    let max = 0;

    Object.keys(numbers).forEach(key => {
        if (numbers[key] > max) {
            max = numbers[key];
        }
    });

    return max;
};

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
import './vue';
import './crud';
import './entities';
import './post';
import './post-layouts';
import './calendar';
import './forms/calendar-date';
import './keep-alive';
import './quick-creator';
import './datagrids';
import './datagrids2';
import './animations';
import './quick-links';
import './webhooks';
import './members';
import './campaign';
import './clipboard';
import './toast';
import './banner';
import './timelines';
import './utility/sortable';
import './utility/formError';
import './utility/dialog';
import './togglers';

// VueJS elements
//import './navigation');
// import './header';
//import './ads');
import './utility/tippy';
import './maintenance';


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
