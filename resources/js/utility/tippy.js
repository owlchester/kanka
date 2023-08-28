import tippy from 'tippy.js';
const entityTooltips = Array();


/**
 * For ajax tooltips, we cache the result (typical for dashboards)
 */
const initAjaxTooltips = () => {
    const elementsAjax = document.querySelectorAll('[data-toggle="tooltip-ajax"]');
    elementsAjax.forEach(e => {
        tippy(e, {
            theme: 'kanka',
            placement: e.dataset.direction ?? 'bottom',
            allowHTML: true,
            delay: 500,
            content: '<i class="fa-solid fa-spin fa-spinner" aria-hidden="true" aria-label="loading..." />',
            arrow: true,
            onShow(instance) {
                let id = e.dataset.id;
                if (id && id in entityTooltips) {
                    return entityTooltips[id];
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
    const elements = document.querySelectorAll('[data-toggle="tooltip"]');

    elements.forEach(e => {
        tippy(e, {
            content: e.dataset.title ?? e.title,
            theme: 'kanka',
            placement: e.dataset.direction ?? 'bottom',
            allowHTML: e.dataset.html ?? false,
            appendTo: e.dataset.append ?? document.body,
            arrow: true,
        });
    });
};

const initDropdowns = () => {
    const elements = document.querySelectorAll('[data-dropdown]');

    elements.forEach(e => {
        let content = e.parentNode.getElementsByClassName('dropdown-menu')[0];
        //console.log('content', content.outerHTML);
        tippy(e, {
            content: '<ul class="dropdown-elements flex flex-col m-0 p-0 shadow-sm">' + content.innerHTML + '</ul>',
            theme: 'kanka-dropdown',
            placement: e.dataset.direction ?? 'bottom',
            allowHTML: true,
            arrow: true,
            interactive: true,
            trigger: "click",
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
