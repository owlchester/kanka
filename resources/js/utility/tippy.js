import tippy from 'tippy.js';
const entityTooltips = Array();


/**
 * For ajax tooltips, we cache the result (typical for dashboards)
 */
const initAjaxTooltips = () => {
    const elementsAjax = document.querySelectorAll('[data-toggle="tooltip-ajax"]');
    elementsAjax.forEach(e => {
        if (e.dataset.loaded === '1') {
            return;
        }
        e.dataset.loaded = '1';
        tippy(e, {
            theme: 'entity-tooltip',
            placement: e.dataset.direction ?? 'bottom',
            allowHTML: true,
            interactive: true,
            delay: 500,
            appendTo: e.dataset.append ?? document.body,
            content: '<i class="fa-solid fa-spin fa-spinner" aria-hidden="true" aria-label="loading..." />',
            arrow: true,
            onShow(instance) {
                let id = e.dataset.id;
                if (id && id in entityTooltips) {
                    instance.setContent(entityTooltips[id]);
                    return;
                }
                fetch(e.dataset.url)
                    .then((response) => response.json())
                    .then((json) => {
                        instance.setContent(json[0]);
                        entityTooltips[id] = json[0];
                    })
                    .catch((error) => {
                            instance.setContent(`Failed loading tooltip. ${error}`);
                        }
                    );
            },
        });
    });
};

const initTooltips = () => {
    let elements = document.querySelectorAll('[data-toggle="tooltip"]');
    elements.forEach(e => {
        initTooltip(e);
    });

    elements = document.querySelectorAll('[data-tooltip]');
    elements.forEach(e => {
        initTooltip(e);
    });
};

const initTooltip = (e) => {
    tippy(e, {
        content: e.dataset.title ?? e.title,
        theme: 'kanka',
        delay: 250,
        placement: e.dataset.direction ?? 'bottom',
        allowHTML: e.dataset.html ?? false,
        appendTo: e.dataset.append ?? document.body,
        arrow: true,
    });
};

const initDropdowns = () => {
    const elements = document.querySelectorAll('[data-dropdown]');

    elements.forEach(e => {
        if (e.dataset.loaded === '1') {
            return;
        }
        let dropdown = e.parentNode.querySelectorAll('.dropdown-menu')[0];
        //console.log('me', e, dropdown);
        e.dataset.loaded = '1';
        tippy(e, {
            content: '<div class="dd-menu flex flex-col gap-1 max-w-2xl">' + dropdown.innerHTML + '</div>',
            theme: 'kanka-dropdown',
            placement: e.dataset.direction ?? 'bottom',
            zIndex: 890,
            allowHTML: true,
            arrow: true,
            interactive: true,
            trigger: "click",
            onShown(instance) {
                window.triggerEvent();
            }
        });
    });
};

const showTooltip = (el, options) => {
    let tooltip = tippy(el, options);
    tooltip.show();
};

initTooltips()
initAjaxTooltips()
initDropdowns()

window.initTooltips = initTooltips;
window.ajaxTooltip = initAjaxTooltips;
window.showTooltip = showTooltip;
window.initDropdowns = initDropdowns;
