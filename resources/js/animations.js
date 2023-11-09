

const initAnimations = () => {
    const collapsers = document.querySelectorAll('[data-animate="collapse"]');
    collapsers.forEach((e) => {
        e.addEventListener('click', toggle);
    });
};

function toggle(e) {
    //e.preventDefault();

    let selector = this.dataset.target;
    if (!selector) {
        selector = this.hash;
    }
    let targets = document.querySelectorAll(selector);
    targets.forEach((e) => {
        e.classList.toggle('hidden');
    });
    this.classList.toggle('animate-collapsed');
};

$(document).on('shown.bs.modal', function (){
    initAnimations();
});
initAnimations();
