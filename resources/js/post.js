const addPermBtn = document.querySelectorAll('.post-perm-add');

const init = () => {
    window.onEvent(function() {
        initPostVisibility();
    });

    if (addPermBtn.length === 0) {
        return;
    }
    registerAdvancedPermissions();
    registerPermissionDeleteEvents();
};

/**
* Add advanced permissions on a post
*/
const registerAdvancedPermissions = () => {
    addPermBtn.forEach((btn) => {
        btn.addEventListener('click', function (ev) {
            ev.preventDefault();
            let type = this.dataset.type;
            let selectElement = document.querySelector('select[name="' + type + '"]');

            if (!selectElement || !selectElement.selectedOptions) {
                return false;
            }
            let template = document.getElementById(this.dataset.template);

            // Support for tag (multiple) select elements (you're welcome Spitfire)
            for (const option of selectElement.selectedOptions) {
                // Add a block
                const clone = template.cloneNode(true);
                clone.classList.remove('hidden');
                clone.removeAttribute('id');
                clone.innerHTML = clone.innerHTML
                    .replace(/\$SELECTEDID\$/g, option.value)
                    .replace(/\$SELECTEDNAME\$/g, option.text);

                const target = document.getElementById('post-perm-target');
                target.insertAdjacentElement('beforebegin', clone);
            }


            let dialog = document.getElementById(this.dataset.dialog);
            dialog.close();

            registerPermissionDeleteEvents();

            // Reset all options to unselected
            for (const option of selectElement.options) {
                option.selected = false;
            }
            selectElement.value = null;
            selectElement.dispatchEvent(new Event('change'));
            return false;
        });
    });
};

/**
 * Remove an advanced permission from a post
 */
const registerPermissionDeleteEvents = () => {
    const deletes = document.querySelectorAll('.post-delete-perm');
    //console.log(deletes);
    deletes.forEach((btn) => {
        if (btn.closest('.hidden')) {
            return;
        }
        if (btn.dataset.init === '1') {
            return;
        }
        btn.dataset.init = '1';
        btn.addEventListener('click', function (e) {
            console.log('clicking', btn, btn.closest('.perm-row'));
            btn.closest('.perm-row').remove();
            e.preventDefault();

            //btn.removeEventListener('click', arguments.callee);
        });
    });
};

const initPostVisibility = () => {
    const form = document.querySelector('form.post-visibility');
    if (!form) {
        return;
    }
    form.onsubmit = function (e) {
        e.preventDefault();
        axios
            .post(this.getAttribute('action'), {visibility_id: this.querySelector('[name="visibility_id"]').value})
            .then((res) => {
                document.getElementById('primary-dialog').close();
                document.getElementById('visibility-icon-' + res.data.post_id).firstElementChild.className = res.data.icon.class;
                window.showToast(res.data.toast);
            });
        return false;
    };
};

init();
