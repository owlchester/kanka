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
            let selected = document.querySelector('select[name="' + type + '"]');

            if (!selected || !selected.value) {
                return false;
            }

            let selectedName = selected.textContent;
            //console.log('selected name for ', type, selectedName);

            // Add a block
            let selector = '#post-perm-' + type + '-template';
            let template = document.getElementById('post-perm-' + type + '-template');
            const clone = template.cloneNode(true);
            clone.classList.remove('hidden');
            clone.removeAttribute('id');
            //let body = $('#post-perm-' + type + '-template').clone().removeClass('hidden').removeAttr('id');
            clone.innerHTML = clone.innerHTML
                .replace(/\$SELECTEDID\$/g, selected.value)
                .replace(/\$SELECTEDNAME\$/g, selectedName);
            //body.html(html).insertBefore($('#post-perm-target'));

            const target = document.getElementById('post-perm-target');
            target.insertAdjacentElement('afterend', clone);

            let dialog = document.getElementById('post-new-' + type);
            dialog.close();

            registerPermissionDeleteEvents();

            // Reset the value
            selected.value = '';
            selected.dispatchEvent(new Event('change'));
            return false;
        });
    });
};

/**
 * Remove an advanced permission from a post
 */
const registerPermissionDeleteEvents = () => {
    const deletes = document.querySelectorAll('.post-delete-perm');
    console.log(deletes);
    deletes.forEach((btn) => {
        btn.addEventListener('click', function (e) {
            //console.log('clicking');
            btn.closest('.perm-row').remove();
            e.preventDefault();

            btn.removeEventListener('click', arguments.callee);
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
