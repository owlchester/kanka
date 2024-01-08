
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

    initRoadmap();
    window.initDialogs();

    document.addEventListener('dialog.loaded', function (e) {
        initRoadmap();
    });
};

const initRoadmap = () => {
    const upvotes = document.querySelectorAll('[data-upvote]');
    upvotes.forEach(i => {
        i
            .addEventListener('click', upvote);
    });
};

function upvote(e) {
    e.preventDefault();
    if (this.dataset.loading) {
        return;
    }
    this.dataset.loading = 1;
    this.innerHTML = '<i class="fa-solid fa-spin fa-spinner" aria-hidden="true"></i>';

    axios.post(this.dataset.upvote)
        .then(res => {
            this.innerHTML = res.data;
            delete this.dataset.loading;
        }).catch(() => {
            this.innerHTML = this.dataset.error;
            this.classList.remove('cursor-pointer');
        });

}

import './utility/dialog';
