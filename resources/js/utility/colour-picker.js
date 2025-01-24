
import Coloris from "@melloware/coloris";

// Key to store colors in the cookie
const RECENT_COLORS_KEY = 'recent_colors';
const MAX_COLORS = 10;

// Function to get cookies as an object
function getCookies() {
    return document.cookie.split(';').reduce((cookies, cookie) => {
        const [key, value] = cookie.split('=').map(c => c.trim());
        if (key && value) cookies[key] = decodeURIComponent(value);
        return cookies;
    }, {});
}

// Function to set a cookie
function setCookie(name, value, days = 30) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${date.toUTCString()}; path=/`;
}

// Function to update the swatches in Coloris
function updateSwatches(colors) {
    Coloris({
        swatches: colors,
    });
}


/**
 * Initiate color for the various fields
 */
function initColourPicker() {
    // Load recent colors from cookie
    const cookies = getCookies();
    let recentColors = cookies[RECENT_COLORS_KEY] ? JSON.parse(cookies[RECENT_COLORS_KEY]) : [];

    // Set initial swatches
    //updateSwatches(recentColors);

    Coloris.init();
    Coloris({
        el: '.spectrum',
        format: 'hex',
        alpha: false,
        theme: 'pill',
        clearButton: true,
        closeButton: true,
        swatches: recentColors
    });

    document.querySelectorAll('.spectrum').forEach(input => {
        if (input.dataset.init === "1") {
            return;
        }
        input.dataset.init = 1;
        input.addEventListener('click', function (e) {
            Coloris({
                parent: input.dataset.appendTo ?? '.container',
            });
        });
        input.addEventListener('change', function (e) {
            const color = event.target.value;

            // Add the new color to the beginning of the array, avoiding duplicates
            recentColors = [color, ...recentColors.filter(c => c !== color)];

            // Limit the array to MAX_COLORS
            if (recentColors.length > MAX_COLORS) {
                recentColors = recentColors.slice(0, MAX_COLORS);
            }

            // Save updated colors to the cookie
            setCookie(RECENT_COLORS_KEY, JSON.stringify(recentColors));

            // Update the swatches
            updateSwatches(recentColors);
        });
        // Don't close the dialog backdrop
        input.addEventListener('close', e => {
            e.stopPropagation();
        });
    });
}


window.onEvent(function() {
    initColourPicker();
});
initColourPicker();
