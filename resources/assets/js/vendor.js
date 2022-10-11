window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');

} catch (e) {}

require('select2');
require('spectrum-colorpicker');


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token.content
        }
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * When clicking on the sidebar, save the new state in a cookie so that the next page load auto-collapsed
 */
$(function () {
    "use strict";

    $(document).on('click', '.sidebar-toggle', function () {
        $('.sidebar-menu').pushMenu('toggle');
        let body = $('body');

        let toggleState = 'opened';
        if(body.hasClass('sidebar-collapse')){
            toggleState = 'closed';
        }

        let date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        let expires = " expires=" + date.toGMTString();
        let secure = location.protocol === 'https:' ? 'secure; ' : '';
        document.cookie = "toggleState="+toggleState+"; path=/; " + secure + "samesite=lax; " + expires;
    });

    let re = new RegExp('toggleState' + "=([^;]+)");
    let value = re.exec(document.cookie);
    let toggleState = (value != null) ? decodeURI(value[1]) : null;
    if (toggleState === 'closed'){
        $("body").addClass('sidebar-collapse hold-transition').delay(100).queue(function(){
            $(this).removeClass('hold-transition');
        });
    }
});


$(document).ready(function () {
    registerVendorEvents();
});

// Select2 open focus bugfix with newer jquery versions
$(document).on('select2:open', () => {
    let allFound = document.querySelectorAll('.select2-container--open .select2-search__field');
    allFound[allFound.length - 1].focus();
});

function registerVendorEvents() {
    // Open select2 dropdowns on focus. Don't add this in
    // initSelect2 since we only need this binded once.
    $(document).on('focus', '.select2.select2-container', function (e) {
        // only open on original attempt - close focus event should not fire open
        if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
            $(this).siblings('select').select2('open');
        }
    });
}
