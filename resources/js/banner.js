/**
 * We sometimes run promotions or warnings at the top of pages. This allows the user to dismiss them
 */
const initDismissableBanners = () => {
    document.querySelectorAll('.banner-notification-dismiss')
        .forEach((el) => {
       el.addEventListener('click', dismissPromo, false);
    });
    document.querySelectorAll('[data-dismiss="tutorial"]')
        .forEach((el) => {
       el.addEventListener('click', dismissTutorial, false);
    });
    document.querySelectorAll('[data-v4-enable-modern]')
        .forEach((el) => {
       el.addEventListener('click', enableModernEntryForm, false);
    });
};

function dismissPromo(e) {
    e.preventDefault();

    let target = this.dataset.dismiss;
    axios.post(this.dataset.url)
        .then(() => {
            if (!target) {
                return;
            }
            let el = document.querySelector(target);
            if (!el) {
                return;
            }
            el.classList.add('hidden');
        });
}
function dismissTutorial(e) {
    e.preventDefault();
    let target = this.dataset.target;
    let btn = e.currentTarget;
    btn.classList.add('loading');
    btn.disabled = true;
    btn.querySelector('i')?.remove();

    axios.post(this.dataset.url)
        .then(() => {
            if (!target) {
                return;
            }
            let el = document.querySelector(target);
            if (!el) {
                return;
            }
            el.classList.add('hidden');
        });
}

function enableModernEntryForm(e) {
    e.preventDefault();
    const btn = e.currentTarget;
    btn.classList.add('loading');
    btn.disabled = true;

    axios.post(btn.dataset.v4EnableModern)
        .then(() => {
            window.entityFormHasUnsavedChanges = false;
            window.location.reload();
        })
        .catch(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
        });
}

initDismissableBanners();
