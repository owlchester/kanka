
const field = document.querySelector('input#has_leap_year');

field.addEventListener('change', function () {
    const target = document.getElementById('calendar-leap-year');
    console.log('me', field.checked);
    if (field.checked) {
        target.classList.remove('hidden');
    } else {
        target.classList.add('hidden');
    }
});
