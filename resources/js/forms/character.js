const organisations = document.querySelector('.character-organisations');
const addBtn = document.querySelector('#add_organisation');
const template = document.querySelector('#template_organisation')

/**
 *
 */
const initCharacterOrganisation = () => {
    if (!organisations) {
        return;
    }
    addBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const child = document.createElement('div');
        child.classList.add('parent-row');
        child.innerHTML = template.innerHTML;
        organisations.append(child);

        // Replace the temp class with the real class. We need this to avoid having two select2 fields
        organisations.querySelectorAll('.tmp-org')?.forEach(child => {
            child.classList.remove('tmp-org');
            child.classList.add('select2');
        });

        // Handle deleting already loaded blocks
        characterDeleteRowHandler();

        // Fake a modal loaded to re-register the togglers
        window.triggerEvent();
        return false;
    });

    characterDeleteRowHandler();
};

/**
 *
 */
const characterDeleteRowHandler = () => {

    const deletes = document.querySelectorAll('.member-delete');
    deletes?.forEach((ele) => {
        if (ele.dataset.init === '1') {
            return;
        }
        ele.dataset.init = '1';
        ele.addEventListener('click', (e) => {
            e.preventDefault();
            ele.closest(ele.dataset.target).remove();
        });
        ele.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter') {
                return;
            }
            ele.click();
        });
    });

    // Always re-calc the sortable traits
    window.initSortable();
    window.initForeignSelect();
};

window.onReady(() => {
    initCharacterOrganisation();
})
