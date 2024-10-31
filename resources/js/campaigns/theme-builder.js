import { colord } from "colord";
import tippy from "tippy.js";
import Coloris from "@melloware/coloris";

const fieldTheme = document.getElementById('field-theme');
let theme = {};


const init = () => {
    loadPreviousConfig();

    Coloris({
        el: '.picker',
        format: 'hsl',
        wrap: false,
        defaultColor: '#cccccc'
    });

    document.querySelectorAll('.picker').forEach(input => {
        input.addEventListener('click', function (e) {
            this.value = window.getComputedStyle(input).backgroundColor;
        });
    });
    document.addEventListener('coloris:pick', event => {
        colourPicked(event);
    });

    const form = document.getElementById('theme-builder');
    form.onsubmit = (e) => {
        const btn = document.getElementById('form-submit-main');
        btn.classList.add('loading');
        btn.setAttribute('disabled', 'disabled');

        // Grab the data from
        fieldTheme.value = JSON.stringify(theme);
        return true;
    };
};

const colourPicked = (event) => {
    updateColour(colord(event.detail.color), event.detail.currentEl.dataset.target);
    event.detail.currentEl.value = '';
};

const loadPreviousConfig = () => {
    let val = fieldTheme.value;
    if (!val) {
        console.log('no config');
        return;
    }
    let json = JSON.parse(val);
    Object.entries(json).forEach(([variable, value]) => {
        theme[variable] = value;
    });
};

const updateColour = (colour, target) => {

    let base = colour.toHslString().replace("hsl(", '').replaceAll(",", '').replace(")", '');
    let focus = darken(colour.toHslString()).toHsl();
    let content = contrast(colour.toHslString()).toHsl();

    // Generates background + focus + content
    let withFocus = ['a', 's', 'p', 'n', 'si'];
    // Generates only background + content
    let alerts = ['in', 'su', 'wa', 'er'];

    if (withFocus.indexOf(target) !== -1) {
        change(target, base);
        change(target + 'f', focus.h + ' ' + focus.s + '% ' + focus.l + '%');
        change(target + 'c', content.h + ' ' + content.s + '% ' + content.l + '%');
    }
    else if (alerts.indexOf(target) !== -1) {
        change(target, base);
        change(target + 'c', content.h + ' ' + content.s + '% ' + content.l + '%');
    }
    else if (target === 'b') {
        let darker = darken(colour.toHslString(), 0.1).toHsl();
        let darkest = darken(colour.toHslString(), 0.2).toHsl();
        change(target + '1', base);
        change(target + '2', darker.h + ' ' + darker.s + '% ' + darker.l + '%');
        change(target + '3', darkest.h + ' ' + darkest.s + '% ' + darkest.l + '%');
        change(target + 'c', content.h + ' ' + content.s + '% ' + content.l + '%');
    }
    else if (target === 'w') {
        let content = contrast(colour.toHslString());
        change('content-wrapper-background', colour.toHex());
        change('theme-main-text', '' + content.toHex());
        change('header-text', '' + content.toHex());
    }
};

const change = (variable, value) => {
    theme[variable] = value;
    //theme['tb-' + variable] = value;
    document.documentElement.style.setProperty('--' + variable, value);
   //document.documentElement.style.setProperty('--tb-' + variable, value);
};

const contrast = (hsl, percentage = 0.8) => {
    if (colord(hsl).isDark()) {
        return colord(hsl).lighten(percentage);
    } else {
        return colord(hsl).darken(percentage);
    }
};

const darken = (hsl, percentage = 0.2) => {
    return colord(hsl).darken(percentage);
};

const initDemoTooltip = () => {
    let e = document.querySelector('[data-toggle="tooltip-demo"]');
    tippy(e, {
        content: '<div class="dd-menu flex flex-col gap-1 max-w-2xl">' + tooltipContent() + '</div>',
        theme: 'kanka',
        delay: 250,
        placement: e.dataset.direction ?? 'bottom',
        arrow: true,
        allowHTML: true,
        interactive: true,
    });
};

const tooltipContent = () => {
    let str = '';

    str += '<div class="tooltip-content p-1">' +
        '<div class="flex gap-2 items-center mb-1">' +
        '<div class="grow entity-names">' +
        ' <span class="entity-name text-xl block">Demo tooltip</span>' +
        '<span class="entity-subtitle text-base block">Subtitle</span>' +
        '</div>' +
        '</div>' +
        '<div class="tooltip-text text-sm">' +
        '<p>Rutrum adipiscing enim pellentesque mi rutrum lacus eget amet nisl dolor maecenas adipiscing diam orci commodo suspendisse tincidunt tristique gravida leo arcu condimentum fusce nunc.</p>' +
        '</div>' +
        '</div>'
    ;
    return str;
};


init();
initDemoTooltip();
