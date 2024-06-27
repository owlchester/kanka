/** Included on various settings subpages **/

const registerBoosters = () => {
    const focusModal = document.getElementById('focus-modal');
    if (focusModal) {
        window.openDialog(focusModal.dataset.target, focusModal.dataset.url);
    }
};
registerBoosters();
