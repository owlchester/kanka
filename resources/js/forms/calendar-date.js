
let calendarAdd, calendarForm, calendarField, calendarHiddenField;
let calendarMonthField, calendarYearField, calendarDayField;
let calendarCancel, calendarLoading, calendarSubForm;
let calendarModalForm;

window.onEvent(function() {
    registercalendarModal();
});

const registercalendarForm = () => {
    calendarAdd = document.querySelector('#entity-calendar-form-add');
    calendarField = document.querySelector('select[name="calendar_id"]');
    calendarHiddenField = document.querySelector('input[name="calendar_id"]'); // Campaigns with a single calendar
    calendarModalForm = document.querySelector('.entity-calendar-modal-form');
    calendarSubForm = document.querySelector('.entity-calendar-subform');
    calendarCancel = document.querySelector('#entity-calendar-form-cancel');
    calendarForm = document.querySelector('.entity-calendar-form');
    calendarYearField = document.querySelector('input[name="calendar_year"]');
    calendarMonthField = document.querySelector('[name="calendar_month"]');
    calendarDayField = document.querySelector('#reminder_day');
    calendarLoading = document.querySelector('.entity-calendar-loading');

    if (calendarAdd) {
        calendarAdd.addEventListener('click', function (e) {
            e.preventDefault();

            calendarAdd.classList.add('hidden');
            calendarForm.classList.remove('hidden');

            let defaultCalendarId = calendarAdd.dataset.defaultCalendar;
            if (defaultCalendarId) {
                calendarHiddenField.value = defaultCalendarId;
                calendarCancel?.classList.remove('hidden');
                calendarSubForm.classList.remove('hidden');
                loadCalendarDates(defaultCalendarId);
            }
            return false;
        });

        calendarCancel.addEventListener('click', function (e) {
            e.preventDefault();
            calendarField.value = null;
            calendarHiddenField.value = null;
            calendarCancel.classList.add('hidden');
            calendarHideSubform();
        });
    }

    if (calendarField) {
        calendarField.onchange = element => {
            calendarSubForm.classList.add('hidden');
            // No new calendar selected? hide everything again
            if (!calendarField.value) {
                calendarHideSubform();
                return false;
            }
            // Load month list
            calendarYearField = document.querySelector('input[name="calendar_year"]');
            calendarMonthField = document.querySelector('[name="calendar_month"]');
            calendarDayField = document.querySelector('#reminder_day');

            if (!calendarYearField && document.querySelector('input[name="year"]')) {
                calendarYearField = document.querySelector('input[name="year"]');
                calendarMonthField = document.querySelector('select[name="month"]');
                calendarDayField = document.querySelector('#reminder_day');
            }
            loadCalendarDates(calendarField.value);
        };
    }

    registerMonthChange();
};

const registercalendarModal = () => {
    if (!document.getElementById('entity-calendar-modal-add')) {
        return;
    }
    calendarAdd = document.querySelector('input[name=calendar-data-url]');
    calendarField = document.querySelector('select[name="calendar_id"]');
    calendarYearField = document.querySelector('input[name="year"]');
    calendarMonthField = document.querySelector('select[name="month"]');
    calendarDayField = document.querySelector('#reminder_day');
    calendarLoading = document.querySelector('.entity-calendar-loading');
    calendarSubForm = document.querySelector('.entity-calendar-subform');

    if (calendarField) {
        calendarField.onchange = event => {
            calendarSubForm.classList.add('hidden');
            // No new calendar selected? hide everything again
            if (!calendarField.value) {
                calendarHideSubform();
                return;
            }
            // Load month list
            loadCalendarDates(calendarField.value);
        };

        //var defaultCalendarId = calendarAdd.data('default-calendar');
        if (calendarField?.value) {
            calendarCancel?.classList.remove('hidden');
            calendarSubForm.classList.remove('hidden');
            loadCalendarDates(calendarField.value);
        }
    }


    const lengthField = document.querySelector('.entity-calendar-subform input[name="length"]');
    if (lengthField) {
        lengthField.addEventListener('focusout', function () {
            if (!this.value) {
                return;
            }
            const url = this.dataset.url.replace('/0/', '/' + calendarField.value + '/');

            const params = {
                day: calendarDayField.value,
                month: calendarMonthField.value,
                year: calendarYearField.value,
                length: this.value,
            };

            axios.get(url, {data: params}).then(res => {
                const warning = document.querySelector('.length-warning');
                if (res.data.overflow == true) {
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            });
        });
    }
    registerMonthChange();
};

/**
 *
 * @param calendarID
 */
const loadCalendarDates = (calendarID) => {
    calendarLoading.classList.remove('hidden');

    calendarID = parseInt(calendarID);
    const url = document.querySelector('input[name="calendar-data-url"]').dataset.url.replace('/0/', '/' + calendarID + '/');
    fetch(url)
        .then((response) => response.json())
        .then(data => {
            let selectedDay = calendarDayField.value;
            calendarYearField.innerHTML = '';
            calendarMonthField.innerHTML = '';
            calendarDayField.innerHTML = '';
            let id = 1;
            let monthLength = 1;
            if (!selectedDay) {
                selectedDay = data.current.day;
            }
            let currentMonth = parseInt(data.current.month);
            const months = Object.entries(data.months);
            months.forEach((position, i) => {
                const option = document.createElement('option');
                option.text = position[1].name;
                option.value = i + 1;
                if (position[0] === currentMonth) {
                    option.selected = true;
                }
                option.dataset.length = position[1].length;
                calendarMonthField.appendChild(option);

                if (id === currentMonth) {
                    monthLength = position[1].length;
                }
                id++;
            });

            for (let d = 1; d <= monthLength; d++) {
                const option = document.createElement('option');
                option.text = d;
                option.value = d;
                if (d == selectedDay) {
                    option.selected = true;
                }
                calendarDayField.appendChild(option);
            }
            calendarLoading.classList.add('hidden');
            calendarSubForm.classList.remove('hidden');

            calendarYearField.value = data.current.year;

            // Put new options
            const periodField = document.querySelector('select.reminder-periodicity');
            while (periodField.options.length > 0) {
                periodField.options.remove(0);
            }

            const options = Object.entries(data.recurring);
            options.forEach((position, i) => {
                //console.log('moon', key, value);
                const option = document.createElement('option');
                option.value = position[0];
                option.text = position[1];
                periodField.appendChild(option);
            });

            document.querySelector('#reminder_length').value = 1;

            // However, if there is only one result, select id.
            if (data.length === 1) {
                calendarMonthField.value = data[0].id;
            }
        });
};

/**
 *
 */
const calendarHideSubform = () => {
    calendarForm.classList.add('hidden');
    calendarAdd.classList.remove('hidden');

    document.querySelector('[name="calendar_day"]').value = null;
    document.querySelector('[name="calendar_month"]').value = null;
    document.querySelector('input[name="calendar_year"]').value = null;
    document.querySelector('select[name="calendar_id"]').value = null;
};

/**
 * Fire an event whenever the month field is changed
 */
const registerMonthChange = () => {
    const field = document.querySelector('#reminder_month');
    if (!field) {
        return;
    }
    field.addEventListener('change', function (event) {
        const selected = field.options[field.selectedIndex];
        const length = selected.dataset.length;
        rebuildCalendarDayList(length);
    });
};

/**
 * Rebuild the calendar day select, and select the current date
 * @param max
 */
const rebuildCalendarDayList = (max) => {
    let selectedDay = parseInt(calendarDayField.value);
    max = parseInt(max);
    if (selectedDay > max) {
        selectedDay = max;
    }

    calendarDayField.innerHTML = '';
    for (let d = 1; d <= max; d++) {
        const newOption = document.createElement('option');
        newOption.text = d;
        newOption.value = d;
        if (d == selectedDay) {
            newOption.selected = true;
        }
        calendarDayField.appendChild(newOption);
    }
};

registercalendarForm();
