import 'cookieconsent/build/cookieconsent.min.js';
const field = document.getElementById('cookieconsent');
let setup, tracking, api;

const initCookieConsent = () => {
    if (!field) {
        console.log('missing cookie consent');
        return;
    }
    console.log('cookie consent present');

    setup = field.dataset.setup;
    api = field.dataset.api;
    //console.log('cookieconsent setup', setup);
    tracking = field.dataset.tracking;

    //console.log('init cookie consent');
    window.cookieconsent.initialise({
        type: 'opt-in',
        layout: 'basic',
        content: setup,
        location: {
            timeout: 5000,
            services: ['kanka'],
            serviceDefinitions: {
                kanka: function () {
                    return {
                        // This service responds with JSON, so we simply need to parse it and return the country code
                        url: api,
                        headers: ['Accept: application/json'],
                        callback: function (done, response) {
                            try {
                                var json = JSON.parse(response);
                                return json.error
                                    ? toError(json)
                                    : {
                                        code: json.country
                                    };
                            } catch (err) {
                                return toError({error: 'Invalid response (' + err + ')'});
                            }
                        }
                    };
                },
            },
        },
        palette: {
            "popup": { "background": "#08083c", "text": "#ffffff" },
            "button": { "background": "#007bff", "text": "#ffffff" },
        },
        onPopupOpen: function () {
            //console.log('<em>onPopupOpen()</em> called');
        },
        onPopupClose: function () {
            //console.log('<em>onPopupClose()</em> called');
        },
        onInitialise: function (status) {
            //console.log('<em>onInitialise()</em> called with status <em>' + status + '</em>');
            if (status === 'allow') {
                initTracking();
            }
        },
        onStatusChange: function (status) {
            //console.log('<em>onStatusChange()</em> called with status <em>' + status + '</em>');
            if (status === 'allow') {
                initTracking();
            }
        },
        onRevokeChoice: function () {
            //console.log('<em>onRevokeChoice()</em> called');
        },
        onNoCookieLaw: function () {
            initTracking();
        }
    });
};

const toError = (obj) => {
    return new Error('Error [' + (obj.code || 'UNKNOWN') + ']: ' + obj.error);
};

const initTracking = () => {
    //console.log('initTracking');
    if (tracking.gtag) {
        //console.log('add gtag');
        const script = document.createElement("script");
        script.async = true;
        script.src = "https://www.googletagmanager.com/gtag/js?id=" + tracking.gtag;
        document.body.appendChild(script);
    }
    if (tracking.gtm) {
        //console.log('add gtm');
        initGTM(window,document,'script','dataLayer', tracking.gtm);
    }
};

const initGTM = (w,d,s,l,i) => {
    w[l]=w[l]||[];
    w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
    var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
    j.async=true;
    j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
    f.parentNode.insertBefore(j,f);
};

initCookieConsent();
