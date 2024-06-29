$(document).ready(function () {
    initPostLayoutsForm();
});

function initPostLayoutsForm() {
    let selector = document.getElementById('post-layout-selector');
    if (!selector) {
        return;
    }

    const fieldEntry = document.querySelector('.field-entry');
    const fieldLocation = document.querySelector('.field-location');
    const fieldDisplay = document.querySelector('.field-display');
    const subform = document.querySelector('#post-layout-subform');
    selector.addEventListener('change', function (e) {
        e.preventDefault();
        let selected = this.value;

        if (selected === '') {
            fieldEntry.style.removeProperty('display');
            fieldEntry.style.removeProperty('display');
            fieldDisplay.style.removeProperty('display');

            subform.style.display = 'none';
        } else {
            fieldEntry.style.display = 'none';
            fieldLocation.style.display = 'none';
            fieldDisplay.style.display = 'none';

            subform.style.removeProperty('display');
        }
    });
}

