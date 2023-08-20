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

initTooltips()
initAjaxTooltips()
initDropdowns()
