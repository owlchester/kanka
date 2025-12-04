import Sortable from "sortablejs"
import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import Onboarding from "./dashboards/onboarding/Onboarding.vue"
import GettingStarted from "./dashboards/widgets/getting-started/GettingStarted.vue"
import vClickOutside from "click-outside-vue3"

class DashboardManager {
    constructor() {
        this.init();
    }

    init() {
        // Initialize one-time setups
        this.initDashboardCalendars(); // Sets up delegation
        this.initPreviewExpander();    // Sets up delegation
        this.initDashboardAdminUI();
        this.initFollow();
        this.initOnboarding();
        this.initGettingStarted();

        // Start observing widgets
        this.initLazyLoader();
    }

    /**
     * Initialize lazy loading for widgets using IntersectionObserver.
     * Fixes bug where widgets were rendered multiple times.
     */
    initLazyLoader() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const widget = entry.target;
                    this.renderWidget(widget);

                    // Important: Stop observing once loaded to prevent re-fetching
                    observer.unobserve(widget);
                }
            });
        }, { threshold: [0] });

        document.querySelectorAll('[data-render]')?.forEach((widget) => {
            observer.observe(widget);
        });
    }

    /**
     * Render an deferred-rendering widget
     */
    renderWidget(widget) {
        axios.get(widget.dataset.render)
            .then(res => {
                const id = widget.dataset.id;
                this.renderCalendar(id, res.data);
            })
            .catch(error => console.error(`Error loading widget ${widget.dataset.id}:`, error));
    }

    renderCalendar(id, html) {
        const loadingEl = document.querySelector('#widget-loading-' + id);
        const bodyEl = document.querySelector('#widget-body-' + id);

        if (loadingEl) loadingEl.classList.add('hidden');
        if (bodyEl) {
            bodyEl.innerHTML = html;
            bodyEl.classList.remove('hidden');
        }

        if (window.triggerEvent) {
            window.triggerEvent();
        }

        // Note: We no longer call initDashboardCalendars() here because
        // we use event delegation now.
    }

    /**
     * Handle Calendar Switchers using Event Delegation.
     * This replaces the need to re-bind listeners after every AJAX call.
     */
    initDashboardCalendars() {
        document.addEventListener('click', (e) => {
            const switcher = e.target.closest('.widget-calendar-switch');
            if (!switcher) return;

            e.preventDefault();

            const url = switcher.dataset.url;
            const id = switcher.dataset.widget;
            const bodyEl = document.querySelector('#widget-body-' + id);
            const loadingEl = document.querySelector('#widget-loading-' + id);

            if (bodyEl) bodyEl.classList.add('hidden');
            if (loadingEl) loadingEl.classList.remove('hidden');

            axios.post(url)
                .then(res => {
                    this.renderCalendar(id, res.data);
                })
                .catch(error => console.error('Error switching calendar:', error));
        });
    }

    /**
     * Admin UI initialization (Sortable, Summernote, Deletions)
     */
    initDashboardAdminUI() {
        const widgetsContainer = document.getElementById('widgets');
        if (widgetsContainer) {
            this.initSortable(widgetsContainer);
        }

        // Event delegation for delete buttons
        document.addEventListener('click', (e) => {
            const img = e.target.closest('[data-img="delete"]');
            if (!img) return;

            e.preventDefault();
            const targetInput = document.querySelector('input[name="' + img.dataset.target + '"]');
            if (targetInput) {
                targetInput.value = 1;
            }

            const preview = img.closest('.preview');
            if (preview) {
                preview.classList.add('hidden');
            }
        });

        // Window event hook (likely for external triggers)
        if (window.onEvent) {
            window.onEvent(() => {
                const summernoteConfig = document.getElementById('summernote-config');
                if (summernoteConfig && window.initSummernote) {
                    window.initSummernote();
                }
                // Delete listeners handled by delegation above, so removed from here.
            });
        }
    }

    initSortable(el) {
        new Sortable(el, {
            handle: '.handle',
            onEnd: () => {
                const url = el.dataset.url;
                // Use URLSearchParams for cleaner serialization
                const params = new URLSearchParams();
                document.querySelectorAll('input[name="widgets[]"]').forEach(input => {
                    params.append(input.name, input.value);
                });

                axios.post(url, params)
                    .then(res => {
                        if (res.data.success && res.data.message && window.showToast) {
                            window.showToast(res.data.message);
                        }
                    })
                    .catch(err => console.error('Error saving order:', err));
            }
        });
    }

    initFollow() {
        const btn = document.querySelector('#campaign-follow');
        const text = document.querySelector('#campaign-follow-text');

        if (!btn || !text) return;

        const updateButtonState = (isFollowing) => {
            text.innerHTML = isFollowing ? btn.dataset.unfollow : btn.dataset.follow;
        };

        // Set initial state
        updateButtonState(!!btn.dataset.following);
        btn.classList.remove('hidden');

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            btn.classList.add('loading');

            axios.post(btn.dataset.url)
                .then(res => {
                    btn.classList.remove('loading');
                    updateButtonState(res.data.following);
                })
                .catch(() => btn.classList.remove('loading'));
        });
    }

    initPreviewExpander() {
        // Use Event Delegation for expanders
        document.addEventListener('click', (e) => {
            const preview = e.target.closest('.preview-switch');
            if (!preview) return;

            e.preventDefault();
            const overlay = document.querySelector('#widget-preview-body-' + preview.dataset.widget);
            if (!overlay) return;

            const gradient = preview.parentNode.querySelector('.gradient-to-base-100');
            const isCollapsed = !overlay.classList.contains('max-h-52');

            if (isCollapsed) {
                // Collapse
                overlay.classList.add('max-h-52');
                preview.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';
                if (gradient) gradient.classList.remove('hidden');
            } else {
                // Expand
                overlay.classList.remove('max-h-52');
                preview.innerHTML = '<i class="fa-solid fa-chevron-up" aria-hidden="true"></i>';
                if (gradient) gradient.classList.add('hidden');
            }
        });
    }

    initOnboarding() {
        const el = document.getElementById('onboarding');
        if (!el) return;

        const app = createApp({});
        app.component('onboarding', Onboarding);
        app.use(vClickOutside);
        app.mount('#onboarding');
    }

    initGettingStarted() {
        const el = document.getElementById('getting-started');
        if (!el) return;

        const app = createApp({});
        app.component('getting-started', GettingStarted);
        app.use(vClickOutside);
        app.use(VueTippy, { theme: 'kanka' });
        app.mount('#getting-started');
    }
}

// Initialize the dashboard
new DashboardManager();
