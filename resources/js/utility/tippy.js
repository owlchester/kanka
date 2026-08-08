import tippy from "tippy.js";
const entityTooltips = Array();

/**
 * For ajax tooltips, we cache the result (typical for dashboards)
 */
const initAjaxTooltips = () => {
    if (window.innerWidth < 768) {
        return;
    }
    const elementsAjax = document.querySelectorAll(
        '[data-toggle="tooltip-ajax"]',
    );
    elementsAjax.forEach((e) => {
        if (e._tippy) {
            return;
        }
        tippy(e, {
            theme: "entity-tooltip",
            placement: e.dataset.direction ?? "bottom",
            allowHTML: true,
            interactive: true,
            delay: 500,
            appendTo: e.dataset.append ?? document.body,
            content:
                '<i class="fa-solid fa-spin fa-spinner" aria-hidden="true" aria-label="loading..." />',
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
                    });
            },
        });
    });
};

const initTooltips = () => {
    let elements = document.querySelectorAll('[data-toggle="tooltip"]');
    elements.forEach((e) => {
        initTooltip(e);
    });

    elements = document.querySelectorAll("[data-tooltip]");
    elements.forEach((e) => {
        initTooltip(e);
    });
};

const initTooltip = (e) => {
    if (e._tippy) {
        return;
    }

    tippy(e, {
        content: e.dataset.title ?? e.title,
        theme: "kanka",
        delay: 250,
        placement: e.dataset.direction ?? "bottom",
        allowHTML: e.dataset.html ?? false,
        appendTo: e.dataset.append
            ? document.querySelector(e.dataset.append)
            : document.body,
        arrow: true,
    });
};

const initDropdownOptions = (instance, sourceDropdown) => {
    const options = instance.popper?.querySelectorAll("[data-dropdown-option]") ?? [];
    const sourceCheckboxes = sourceDropdown.querySelectorAll("[data-dropdown-option-checkbox]");

    options.forEach((option) => {
        const checkbox = option.querySelector("[data-dropdown-option-checkbox]");
        const sourceCheckbox = Array.from(sourceCheckboxes).find(
            (source) => source.name === checkbox?.name,
        );
        if (checkbox && sourceCheckbox) {
            checkbox.checked = sourceCheckbox.checked;
            if (!option.dataset.initialized) {
                checkbox.addEventListener("change", () => {
                    sourceCheckbox.checked = checkbox.checked;
                });
            }
        }

        if (option.dataset.initialized) {
            return;
        }
        option.dataset.initialized = "true";

        const toggle = option.querySelector("[data-dropdown-option-help-toggle]");
        const help = option.querySelector("[data-dropdown-option-help]");
        if (!toggle || !help) {
            return;
        }

        const toggleHelp = (event) => {
            event.preventDefault();
            event.stopPropagation();
            const hidden = help.classList.toggle("hidden");
            toggle.setAttribute("aria-expanded", String(!hidden));
            requestAnimationFrame(() => instance.popperInstance?.forceUpdate());
        };

        toggle.addEventListener("click", toggleHelp);
        toggle.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                toggleHelp(event);
            }
        });
    });
};

const initDropdowns = () => {
    const elements = document.querySelectorAll("[data-dropdown]");

    elements.forEach((e) => {
        if (e._tippy) {
            return;
        }
        let dropdown = e.parentNode.querySelectorAll(".dropdown-menu")[0];
        tippy(e, {
            content:
                '<div class="dd-menu flex flex-col max-w-2xl">' +
                dropdown.innerHTML +
                "</div>",
            theme: "kanka-dropdown",
            placement: e.dataset.direction ?? "bottom",
            appendTo: e.dataset.append
                ? document.querySelector(e.dataset.append)
                : document.body,
            zIndex: 1060,
            allowHTML: true,
            arrow: true,
            interactive: true,
            trigger: "click",
            onShown(instance) {
                initDropdownOptions(instance, dropdown);
                window.triggerEvent();
            },
        });
    });
};

const showTooltip = (el, options) => {
    let tooltip = tippy(el, options);
    tooltip.show();
};

initTooltips();
initAjaxTooltips();
initDropdowns();

window.initTooltips = initTooltips;
window.ajaxTooltip = initAjaxTooltips;
window.showTooltip = showTooltip;
window.initDropdowns = initDropdowns;
