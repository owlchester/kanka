
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

window.onload = function (event) {
    const wrapper = document.getElementById('nav-mobile-toggler');

    wrapper.addEventListener('click', () => {
        wrapper.classList.toggle('open');
    });

    window.initDialogs();
    initRoadmap();
};

const initRoadmap = () => {
    const loadedModal = document.querySelector('[name="open-dialog"]');

    if (loadedModal) {
        window.openDialog(loadedModal.value);
    }
};

import './utility/dialog';
