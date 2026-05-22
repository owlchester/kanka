const COOKIE_LAW_COUNTRIES = [
    'AT', 'BE', 'BG', 'HR', 'CZ', 'CY', 'DK', 'EE', 'FI', 'FR',
    'DE', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
    'PL', 'PT', 'SK', 'ES', 'SE', 'GB', 'GR',
];

const field = document.getElementById('cookieconsent');

const getCookie = (name) => {
    const match = document.cookie.match(new RegExp('(^| )' + name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '=([^;]+)'));
    return match ? match[2] : null;
};

const setCookie = (name, value, days) => {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = name + '=' + value + '; expires=' + date.toUTCString() + '; path=/; SameSite=Lax; Secure';
};

const initTracking = () => {
    if (!field) {
        return;
    }
    if (field.dataset.gtag) {
        allConsentGranted();
    }
    if (field.dataset.gtm) {
        initGTM(window, document, 'script', 'dataLayer', field.dataset.gtm);
    }
};

const initGTM = (w, d, s, l, i) => {
    w[l] = w[l] || [];
    w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
    const f = d.getElementsByTagName(s)[0];
    const j = d.createElement(s);
    const dl = l !== 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
};

const allConsentGranted = () => {
    gtag('consent', 'update', {
        'ad_user_data': 'granted',
        'ad_personalization': 'granted',
        'ad_storage': 'granted',
        'analytics_storage': 'granted',
    });
};

const initOnLoad = () => {
    if (!field) {
        return;
    }
    const country = field.dataset.country;
    const status = getCookie('cookieconsent_status');

    if (!COOKIE_LAW_COUNTRIES.includes(country)) {
        initTracking();
        return;
    }

    if (status === 'allow') {
        initTracking();
    }
};

window.footerCookieConsent = () => ({
    showConsent: false,
    init() {
        if (!field) {
            return;
        }
        const country = field.dataset.country;
        const status = getCookie('cookieconsent_status');
        this.showConsent = COOKIE_LAW_COUNTRIES.includes(country) && !status;
    },
    accept() {
        setCookie('cookieconsent_status', 'allow', 365);
        this.showConsent = false;
        initTracking();
    },
    reject() {
        setCookie('cookieconsent_status', 'deny', 365);
        this.showConsent = false;
    },
    reset() {
        setCookie('cookieconsent_status', '', -1);
        this.showConsent = true;
    },
});

initOnLoad();
