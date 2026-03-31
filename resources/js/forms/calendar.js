
const field = document.querySelector('input#has_leap_year');

field.addEventListener('change', function () {
    const target = document.getElementById('calendar-leap-year');
    if (field.checked) {
        target.classList.remove('hidden');
    } else {
        target.classList.add('hidden');
    }
});

const validateEraYears = (row) => {
    const nameInput = row.querySelector('input[name="era_name[]"]');
    const startInput = row.querySelector('input[name="era_start_year[]"]');
    const endInput = row.querySelector('input[name="era_end_year[]"]');
    if (!nameInput || !startInput || !endInput) {
        return;
    }

    const checkName = () => {
        nameInput.setCustomValidity(nameInput.value.trim() === '' ? nameInput.dataset.errorNameRequired : '');
    };

    const checkYears = () => {
        const start = startInput.value;
        const end = endInput.value;
        if (start === '' && end === '') {
            startInput.setCustomValidity(startInput.dataset.errorYearRequired);
        } else {
            startInput.setCustomValidity('');
        }
        if (start !== '' && end !== '' && parseInt(start) > parseInt(end)) {
            endInput.setCustomValidity(endInput.dataset.errorYearOrder);
        } else {
            endInput.setCustomValidity('');
        }
    };

    nameInput.addEventListener('input', checkName);
    startInput.addEventListener('input', checkYears);
    endInput.addEventListener('input', checkYears);

    checkName();
    checkYears();
};

const registerEraYearValidation = () => {
    document.querySelectorAll('.calendar-eras .parent-delete-row').forEach(row => {
        if (row.dataset.eraValidationInit === '1') {
            return;
        }
        row.dataset.eraValidationInit = '1';
        validateEraYears(row);
    });
};

registerEraYearValidation();
window.onEvent(registerEraYearValidation);
