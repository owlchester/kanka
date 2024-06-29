export default function deleteConfirm() {
    // Delete confirm dialog
    // const elements = document.querySelectorAll('.delete-confirm');
    // elements.forEach(btn => {
    //     btn.addEventListener('click', function () {
    //         let name = this.dataset.name;
    //         let target = this.dataset.deleteTarget;
    //         let targetModal = this.dataset.target;
    //
    //         $(targetModal).find('.target-name').text(name);
    //
    //         if (this.dataset.mirrored) {
    //             $('#delete-confirm-mirror').show();
    //         } else {
    //             $('#delete-confirm-mirror').hide();
    //         }
    //
    //         if ($(this).data('recoverable')) {
    //             $(targetModal).find('.permanent').hide();
    //             $(targetModal).find('.recoverable').show();
    //         } else {
    //             $(targetModal).find('.recoverable').hide();
    //             $(targetModal).find('.permanent').show();
    //         }
    //
    //         if (target) {
    //             $('.delete-confirm-submit').data('target', target);
    //         }
    //     });
    // });


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
