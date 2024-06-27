const initWebhooksForm = () => {
    let selector = document.getElementById('webhook-selector');
    if (!selector) {
        return false;
    }
    selector.addEventListener('change', function (e) {
        e.preventDefault();
        let selected = this.options[this.selectedIndex];
        document.querySelector('.webhook-subform').classList.add('hidden');
        document.querySelector(selected.dataset.target)?.classList.remove('hidden');
    });
};
initWebhooksForm();
