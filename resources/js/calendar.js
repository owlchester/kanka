const calendarYearSwitcher = document.querySelector('#calendar-year-switcher');

$(document).ready(function() {
    $(document).on('shown.bs.modal', function() {
        initCalendarEventModal();
    });
});

const initCalendarEventBlock = () => {
    const blocks = document.querySelectorAll('.calendar-event-block');
    blocks.forEach(block => {
        if (block.dataset.toggle !== 'dialog' && block.dataset.url) {
            block.addEventListener('click', function () {
                window.location = block.dataset.url;
            });
        }
    });
};

const initCalendarEventModal = () => {
    const recurring = document.querySelector('select[name="recurring_periodicity"]');
    if (!recurring) {
        return;
    }
    recurring.onchange = function (e) {
        const until = document.querySelector('.field-recurring-until');
        if (recurring.value) {
            until.classList.remove('hidden');
        } else {
            until.classList.add('hidden');
        }
    };

    const first = document.querySelector('#calendar-event-first');
    const newEvent = document.querySelector('.calendar-new-event-field');
    const existingEvent = document.querySelector('.calendar-existing-event-field');
    const subform = document.querySelector('#calendar-event-subform');

    document.querySelector('#calendar-action-existing').addEventListener('click', function(e) {
        e.preventDefault();
        first.classList.add('!hidden');
        newEvent.classList.add('hidden');
        existingEvent.classList.remove('hidden');
        subform.classList.remove('hidden');
    });

    document.querySelector('#calendar-action-new').addEventListener('click', function(e) {
        e.preventDefault();
        first.classList.add('!hidden');
        newEvent.classList.remove('hidden');
        existingEvent.classList.add('hidden');
        subform.classList.remove('hidden');
    });

    document.querySelector('#calendar-event-switch').addEventListener('click', function(e) {
        e.preventDefault();
        subform.classList.add('hidden');
        first.classList.remove('!hidden');
        existingEvent.classList.remove('hidden');
        newEvent.classList.remove('hidden');
    });
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


if (calendarYearSwitcher) {
    initCalendarEventBlock();
}
registerKeyboardShortcuts();

if (document.querySelector('select[name="recurring_periodicity"]')) {
    initCalendarEventModal();
}
