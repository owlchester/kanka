window.onEvent(function() {
    registerPrivacyTogglers();
});


const registerPrivacyTogglers = () => {
    const elements = document.querySelectorAll('[data-toggle="private"]');
    elements.forEach((element) => {
        registerPrivacyToggler(element);
    });
};

const registerPrivacyToggler = (element) => {
    if (element.dataset.togglerinit === '1') {
        return;
    }
    element.dataset.togglerinit = '1';
    element.addEventListener('click', function (event) {
        const closestInputSibling = element.previousElementSibling;
        if (element.classList.contains('fa-lock-keyhole')) {
            element.classList.remove('fa-lock-keyhole', 'fa-solid');
            element.classList.add('fa-unlock-keyhole', 'fa-regular');
            element.setAttribute('title', element.dataset.public);
            closestInputSibling.value = 0;
        } else {
            element.classList.remove('fa-unlock-keyhole', 'fa-regular');
            element.classList.add('fa-lock-keyhole', 'fa-solid');
            element.setAttribute('title', element.dataset.private);
            closestInputSibling.value = 1;
            //element.prev('input:hidden').val("1");
        }
    });
};



/**
 * Show a warning when the entity is set to private
 */
const registerEntityPrivacyAlert = () => {
    const field = document.querySelector('input[data-toggle="entity-privacy"]');
    if (!field) {
        return;
    }
    field.addEventListener('change', function () {
        let selector = document.getElementById('entity-is-private');
        // Bookmarks have this field but no permissions. This should be handled differently
        if (!selector) {
            return;
        }
        if (this.checked) {
            selector.classList.remove('hidden')
        } else {
            selector.classList.add('hidden')
        }
    });
};

// Look for a form to save
registerPrivacyTogglers();
registerEntityPrivacyAlert();
