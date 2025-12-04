import './events';
import './tags';
import './components/select2.js';
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
import './datagrids2';
import './animations';
import './bookmarks';
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
import './utility/colour-picker';
import './togglers';

// VueJS elements
import './header'
import './gallery/selection'
import './utility/tippy';
import './maintenance';

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
    initDynamicDelete();
    initImageRemoval();
    initFeedbackButtons();
    initDismissible();
    initPermBtn();
});

function initAdblocker() {
    let adscript = document.getElementById('ad-client');
    if (!adscript)  return;

    fetch(adscript.src, { method: 'HEAD', mode: 'no-cors' })
        .catch(() => {
            document.getElementById('adblock-plea')?.classList.remove('hidden');
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

            // 1. Deactivate current active elements within this container
            parent.querySelector('.nav-tabs li.active')?.classList.remove('active');
            parent.querySelector('.tab-pane.active')?.classList.remove('active');

            // 2. Activate new elements
            tab.parentElement.classList.add('active');
            const target = document.querySelector(tab.getAttribute('href'));
            target?.classList.add('active');
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
                // ... existing submission logic ...
                ele.classList.add('loading');
                ele.innerHTML = '';
                const target = document.querySelector(ele.dataset.target);
                if (!target) {
                    console.error('Unknown target', target);
                } else {
                    target.requestSubmit();
                }

                return;
            }

            // Save original text to restore it later
            const originalText = ele.innerHTML;

            ele.dataset.confirming = '1';
            ele.querySelector('span').classList.add('md:inline');
            ele.querySelector('span').innerHTML = ele.dataset.confirm;

            // Reset if user clicks away (loses focus)
            ele.addEventListener('blur', function() {
                ele.dataset.confirming = '0';
                ele.innerHTML = originalText;
            }, { once: true });
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

            target.addEventListener('transitionend', () => {
                target.remove();
            }, { once: true });
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


window.initForeignSelect();
window.initDialogs();
initSubmenuSwitcher();

manageTabs();

initAjaxPagination();
initDynamicDelete();
initImageRemoval();
initFeedbackButtons();
initDismissible();
initAdblocker();
