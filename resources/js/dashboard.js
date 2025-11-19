import Sortable from "sortablejs"
import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import Onboarding from "./dashboards/onboarding/Onboarding.vue"
import GettingStarted from "./dashboards/widgets/getting-started/GettingStarted.vue"
import vClickOutside from "click-outside-vue3"


const widgetVisible = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if(entry.isIntersecting) {
            entries.forEach(widget => {
                renderWidget(widget.target);
            });
        }
    });
}, { threshold: [0] });

/**
 *
 */
const initDashboardAdminUI = () => {
    if (!document.querySelector('.campaign-dashboard-widgets')) {
        return;
    }

    let el = document.getElementById('widgets');
    new Sortable(el, {
        handle: '.handle',
        onEnd: function (/**Event*/evt) {

            const url = document.getElementById('widgets').dataset.url;
            let serializedData = '';
            const inputs = document.querySelectorAll('input[name="widgets[]"]');
            inputs.forEach(input => {
                serializedData += `${input.name}=${encodeURIComponent(input.value)}&`;
            });

            axios.post(url, serializedData)
                .then(res => {
                    if (res.data.success && res.data.message) {
                        window.showToast(res.data.message);
                    }
                });
        }
    });

    window.onEvent(function() {
        const summernoteConfig = document.getElementById('summernote-config');
        if (summernoteConfig) {
            window.initSummernote();
        }

        const img = document.querySelectorAll('[data-img="delete"]');
        img.forEach(i => {
            i.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector('input[name=' + i.dataset.target + ']').value = 1;
                i.closest('.preview').classList.add('hidden');
            });
        });
    });
};


/**
 *
 */
const initDashboardCalendars = () => {
    const switchers = document.querySelectorAll('.widget-calendar-switch');
    if (switchers.length === 0) {
        return;
    }
    switchers.forEach(switcher => {
        switcher.addEventListener('click', (e) => {
            e.preventDefault();

            const url = switcher.dataset.url;
            const id = switcher.dataset.widget;

            document.querySelector('#widget-body-' + id).classList.add('hidden');
            document.querySelector('#widget-loading-' + id).classList.remove('hidden');

            axios.post(url)
                .then(res => {
                    renderCalendar(id, res.data);
                });
        });
    });
};

/**
 * Follow / Unfollow a campaign
 */
const initFollow = () => {
    const btn = document.querySelector('#campaign-follow');
    const text = document.querySelector('#campaign-follow-text');

    if (!btn) {
        return;
    }

    const status = btn.dataset.following;
    if (status) {
        text.innerHTML = btn.dataset.unfollow;
    } else {
        text.innerHTML = btn.dataset.follow;
    }
    btn.classList.remove('hidden');

    btn.addEventListener('click', function (e) {
        btn.classList.add('loading');
        e.preventDefault();
        axios.post(btn.dataset.url)
            .then(res => {
                btn.classList.remove('loading');
                if (res.data.following) {
                    text.innerHTML = btn.dataset.unfollow;
                } else {
                    text.innerHTML = btn.dataset.follow;
                }
        });
    });
};


/**
 * Render an deferred-rendering widget
 * @param widget
 */
const renderWidget = (widget) => {
    axios.get(widget.dataset.render)
        .then(res => {
            let id = widget.dataset.id;
            renderCalendar(id, res.data);
    });
};

const renderCalendar = (id, html) => {
    document.querySelector('#widget-loading-' + id).classList.add('hidden');
    document.querySelector('#widget-body-' + id).innerHTML = html;
    document.querySelector('#widget-body-' + id).classList.remove('hidden');
    window.triggerEvent();
    initDashboardCalendars();
};

const initPreviewExpander = () => {
    document.querySelectorAll('.preview-switch').forEach(preview => {
        preview.addEventListener('click', function (e) {
            e.preventDefault();

            let overlay = document.querySelector('#widget-preview-body-' + preview.dataset.widget);
            if (overlay.classList.contains('max-h-52')) {
                overlay.classList.remove('max-h-52');
                preview.innerHTML = '<i class="fa-solid fa-chevron-up" aria-hidden="true"></i>';
                preview.parentNode.querySelector('.gradient-to-base-100').classList.add('hidden');
            } else {
                overlay.classList.add('max-h-52');
                preview.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';
                preview.parentNode.querySelector('.gradient-to-base-100').classList.remove('hidden');
            }
        });
    });
};

const initOnboarding = () => {
    const app = createApp({});
    app.component('onboarding', Onboarding);
    app.use(vClickOutside);
    app.mount('#onboarding');
};

const initGettingStarted = () => {
    const selector = document.getElementById('getting-started');
    if (!selector) {
        return;
    }
    const app = createApp({});
    app.component('getting-started', GettingStarted);
    app.use(vClickOutside);
    app.use(VueTippy, {
        theme: 'kanka',
    });
    app.mount('#getting-started');
};

initDashboardCalendars();
initFollow();
initPreviewExpander();
initDashboardAdminUI();
initOnboarding();
initGettingStarted();

document.querySelectorAll('[data-render]')?.forEach((i) => {
    widgetVisible.observe(i);
});
