export const initEntryDate = (row) => {
    const calendar = row.querySelector('[data-date-calendar]');
    const year = row.querySelector('[data-date-year]');
    const month = row.querySelector('[data-date-month]');
    const day = row.querySelector('[data-date-day]');
    const options = JSON.parse(row.dataset.calendars);

    calendar.addEventListener('change', () => {
        const selected = options[calendar.value];
        month.replaceChildren(new Option('—', ''));
        (selected?.months || []).forEach((label, index) => month.add(new Option(label, String(index + 1))));
        year.value = selected?.current?.year ?? '';
        month.value = selected?.current?.month ?? '';
        day.value = selected?.current?.day ?? '';
    });
};
