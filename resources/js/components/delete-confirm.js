export default function deleteConfirm() {
    // Submit modal form
    const elements = document.querySelectorAll('.delete-confirm-submit');
    elements.forEach(btn => {
        if(btn.dataset.deleteInit === '1') {
            return;
        }
        btn.dataset.deleteInit = '1';
        btn.addEventListener('click', function (e) {
            let target = this.dataset.target;
            //console.log('Submit delete confirmation', target);
            if (target) {
                document.querySelector('#' + target + ' input[name=remove_mirrored]').value =
                document.getElementById('delete-confirm-mirror-checkbox').checked ? 1 : 0;
                document.getElementById(target).requestSubmit();
            } else {
                document.getElementById('delete-confirm-form').requestSubmit();
            }
        });
    });
}
