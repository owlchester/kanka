
const initCalendarEventBlock = () => {
    if (!document.querySelector('#calendar-year-switcher')) {
        return;
    }
    const blocks = document.querySelectorAll('.calendar-event-block');
    blocks.forEach(block => {
        if (block.dataset.toggle !== 'dialog' && block.dataset.url) {
            block.addEventListener('click', function () {
                window.location = block.dataset.url;
            });
        }
    });
    document.querySelectorAll("[data-dbclick]").forEach(function (td) {
        td.addEventListener("dblclick", function () {
            window.openDialog('primary-dialog', td.dataset.url);
        });
    });
};

const initCalendarEventModal = () => {
    const recurring = document.querySelector('select[name="recurring_periodicity"]');
    if (!recurring) {
        return;
    }
    // Logic extracted to a function so it can be run on init and on change
    const toggleUntil = () => {
        const until = document.querySelector('.field-recurring-until');
        // Safety check in case the field is missing in specific forms
        if (!until) return;

        if (recurring.value) {
            until.classList.remove('hidden');
        } else {
            until.classList.add('hidden');
        }
    };

    // Use addEventListener instead of onchange property
    recurring.addEventListener('change', toggleUntil);

    // Run immediately to sync UI with current value (e.g. editing an existing event)
    toggleUntil();
};

/**
 * Register keyboard shortcuts for previous/next view
 */
const registerKeyboardShortcuts = () => {
    const hasNav = document.querySelector('[data-shortcut="previous"]') || document.querySelector('[data-shortcut="next"]');
    if (!hasNav) {
        return;
    }

    document.addEventListener('keydown', function(e) {
        // Ctrl + <- for previous, Ctrl + -> for next
        if (e.ctrlKey || e.metaKey) {
            // Modern replacement for deprecated e.which
            if (e.key === 'ArrowLeft') {
                const previous = document.querySelector('[data-shortcut="previous"]');
                // Safety check: element might not exist (e.g. first page)
                if (previous) {
                    previous.classList.add('loading');
                    previous.click();
                }
            } else if (e.key === 'ArrowRight') {
                const next = document.querySelector('[data-shortcut="next"]');
                if (next) {
                    next.classList.add('loading');
                    next.click();
                }
            }
        }
    });
};


initCalendarEventBlock();
registerKeyboardShortcuts();
initCalendarEventModal();

window.onEvent(function() {
    initCalendarEventModal();
});
