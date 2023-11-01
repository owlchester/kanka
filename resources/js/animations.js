

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
    let target = document.querySelector(selector);
    //console.log('target', target);

    this.classList.toggle('animate-collapsed');
    target.classList.toggle('hidden');
};

$(document).on('shown.bs.modal', function (){
    initAnimations();
});
initAnimations();
