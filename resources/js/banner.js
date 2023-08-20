/**
 * We sometimes run promotions or warnings at the top of pages. This allows the user to dismiss them
 */
const initBannerPromoDismiss = () => {
    document.querySelectorAll('.banner-notification-dismiss')
        .forEach((el) => {
       el.addEventListener('click', dismissPromo, false);
    });
};

function dismissPromo(e) {
    e.preventDefault();

    axios.post(this.dataset.url)
        .then(() => {
            let target = this.dataset.dismiss;
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
initBannerPromoDismiss();
