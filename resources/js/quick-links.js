const initQuickLinksForm = () => {
    const selector = document.getElementById('bookmark-selector');
    if (!selector) {
        return false;
    }
    selector.addEventListener('change', function (e) {
        e.preventDefault();
        const selected = selector.options[selector.selectedIndex];

        const subforms = document.querySelectorAll('.bookmark-subform');
        subforms.forEach(subform => {
            subform.classList.add('opacity-0', 'invisible', 'h-0');
        });
        let target = document.querySelector(selected.dataset.target);
        if (target) {
            target.classList.remove('opacity-0', 'invisible', 'h-0');
        }
    });
};

const showFilterField = () => {
    const selector = document.getElementById('entity-selector');
    if (!selector) {
        return false;
    } else if (selector.value !== '') {
        document.getElementById('filter-subform').style.removeProperty('display');
    }
    selector.addEventListener('change', function () {
        if (selector.value === '') {
            document.getElementById('filter-subform').style.display = 'none';
        } else {
            document.getElementById('filter-subform').style.removeProperty('display');
        }
    });
};

initQuickLinksForm();
showFilterField();
