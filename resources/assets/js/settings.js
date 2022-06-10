/** Included on various settings subpages **/
$(document).ready(function () {
    registerBoosters();
});


function registerBoosters() {
    let focusModal = $('#focus-modal');
    if (focusModal.length === 1) {
        focusModal.modal('show');
    }
}
