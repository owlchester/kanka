
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
    document.querySelectorAll(".calendar-day-block").forEach(function (td) {
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
    recurring.onchange = function () {
        const until = document.querySelector('.field-recurring-until');
        if (recurring.value) {
            until.classList.remove('hidden');
        } else {
            until.classList.add('hidden');
        }
    };
};

/**
 * Register keyboard shortcuts for previous/next view
 */
const registerKeyboardShortcuts = () => {
    if (!document.querySelector('[data-shortcut="previous"]')) {
        return;
    }
    document.addEventListener('keydown', function(e) {
        // Ctrl + <- for previous, Ctrl + -> for next
        if ((e.ctrlKey || e.metaKey) && e.which === 37) {
            const previous = document.querySelector('[data-shortcut="previous"]');
            previous.classList.add('loading');
            previous.click();
        } else if ((e.ctrlKey || e.metaKey) && e.which === 39) {
            const next = document.querySelector('[data-shortcut="next"]');
            next.classList.add('loading');
            next.click();
        }
    });
};


initCalendarEventBlock();
registerKeyboardShortcuts();

if (document.querySelector('select[name="recurring_periodicity"]')) {
    initCalendarEventModal();
}
window.onEvent(function() {
    initCalendarEventModal();
});
