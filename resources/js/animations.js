const initAnimations = () => {
    const collapsers = document.querySelectorAll('[data-animate="collapse"]');
    collapsers.forEach((e) => {
        e.addEventListener('click', toggle);
    });

    const revelers = document.querySelectorAll('[data-animate="reveal"]');
    revelers.forEach((e) => {
        e.addEventListener('change', change);
    });
};

function toggle(e) {
    e.preventDefault();

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

function change (e) {
    let target = document.querySelector(this.dataset.target);
    //console.log('target', target, this.dataset.target);
    if (!this.value) {
        target.classList.add('hidden');
    } else {
        target.classList.remove('hidden');
    }
}

window.onEvent(function() {
    initAnimations();
});
initAnimations();
