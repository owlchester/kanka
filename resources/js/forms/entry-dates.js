export const initEntryDate = (row) => {
    const calendar = row.querySelector('[data-date-calendar]');
    const year = row.querySelector('[data-date-year]');
    const month = row.querySelector('[data-date-month]');
    const day = row.querySelector('[data-date-day]');
    const recurrence = row.querySelector('[data-date-recurrence]');
    const options = JSON.parse(row.dataset.calendars);

    calendar.addEventListener('change', () => {
        const selected = options[calendar.value];
        month.replaceChildren(new Option('—', ''));
        (selected?.months || []).forEach((label, index) => month.add(new Option(label, String(index + 1))));
        year.value = selected?.current?.year ?? '';
        month.value = selected?.current?.month ?? '';
        day.value = selected?.current?.day ?? '';
        if (recurrence) {
            const current = recurrence.value;
            recurrence.replaceChildren();
            Object.entries(selected?.recurrence || {}).forEach(([value, label]) => {
                if (typeof label === 'object' && label !== null) {
                    const group = document.createElement('optgroup');
                    group.label = value;
                    Object.entries(label).forEach(([phase, text]) => group.append(new Option(text, phase)));
                    recurrence.append(group);
                } else {
                    recurrence.add(new Option(label, value));
                }
            });
            recurrence.value = current;
            if (recurrence.value !== current) recurrence.value = '';
        }
    });
};
