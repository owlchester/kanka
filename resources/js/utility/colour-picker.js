import "@melloware/coloris/dist/coloris.css";
import Coloris from "@melloware/coloris";

const RECENT_COLORS_KEY = 'recent_colors';
const MAX_COLORS = 10;

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
    const stored = localStorage.getItem(RECENT_COLORS_KEY);
    let recentColors = stored ? JSON.parse(stored) : [];

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

            localStorage.setItem(RECENT_COLORS_KEY, JSON.stringify(recentColors));

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
