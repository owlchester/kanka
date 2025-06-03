let maxFields = false;
let liveEditURL, liveEditModal;

const init = () => {
    initLiveAttributes();
    if (!document.getElementById('add_attribute_target')) {
        return;
    }

    const maxConfig = document.querySelector('[data-max-fields]');
    if (maxConfig) {
        maxFields = maxConfig.dataset.maxFields;
    }
};

const initLiveAttributes = () => {
    const config = document.querySelector('[name="live-attribute-config"]');
    if (!config) {
        return;
    }

    liveEditURL = config.dataset.live;
    liveEditModal = document.getElementById('live-attribute-dialog');

    // Add the live-edit-parsed attribute to variables to confirm that they are valid
    let uid = 1;
    const fields = document.querySelectorAll('.live-edit');
    fields.forEach(field => {
        field.classList.add('live-edit-parsed');
        field.dataset.uid = uid;
        uid++;
    });

    const parsedFields = document.querySelectorAll('.live-edit-parsed');
    parsedFields.forEach(field => {
        field.addEventListener('click', function (e) {
            // If clicking on a link inside the live-edit link, just follow the link, don't open the editor
            if (e.target.tagName === 'A') {
                return;
            }
            const id = field.dataset.id;
            const url = liveEditURL + '?id=' + id + '&uid=' + field.dataset.uid;

            window.onEvent(function() {
                listenToLiveForm();
            });
            window.openDialog('live-attribute-dialog', url);

        });
    });

    window.onEvent(function() {
        initNewLiveAttributeForm();
    });
};

const listenToLiveForm = () => {
    liveEditModal.querySelector('form').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        axios.post(form.getAttribute('action'), formData)
            .then(result => {
                liveEditModal.querySelector('article').innerHTML = '';
                const dialog = document.getElementById('live-attribute-dialog');
                dialog.close();

                const target = document.querySelector('[data-uid="' + result.data.uid + '"]');
                //console.log('looking for', '[data-uid="' + result.uid + '"]', target);
                target.dataset.attribute = result.data.attribute;
                target.innerHTML = result.data.value;
                if (result.data.value) {
                    target.classList.remove('empty-value');
                } else {
                    target.classList.add('empty-value');
                }

                window.showToast(result.data.success);
            })
            .catch (() => {
                //alert('error! check console logs');
                //console.error('live-edit-error', result);
                document.getElementById('live-attribute-dialog').close();
            });

        return false;
    };
};

const initNewLiveAttributeForm = () => {
    const forms = document.querySelectorAll('form.live-attribute-form');
    const primaryModal = document.getElementById('primary-dialog');
    forms.forEach(function (form) {
        form.onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            axios.post(form.getAttribute('action'), formData)
                .then(res => {
                    primaryModal.querySelector('article').innerHTML = '';
                    primaryModal.close();

                    const target = document.querySelector('[data-live-id="' + res.data.id + '"]');
                    //console.log('looking for', '[data-uid="' + result.uid + '"]', target);
                    target.dataset.dataAttribute = res.data.attribute;
                    target.innerHTML = res.data.value;

                    window.showToast(res.data.success);
                })
                .catch(err => {
                    if (err.response.data.message) {
                        window.showToast(err.response.data.message, 'error');
                    }
                    primaryModal.close();
                });
        };
    });
};

init();
