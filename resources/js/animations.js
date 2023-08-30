const collapsers = document.querySelectorAll('[data-animate="collapse"]');

const initAnimations = () => {

    collapsers.forEach((e) => {
        e.addEventListener('click', toggle);
    });
};

function toggle(e) {
    e.preventDefault();

    let target = document.querySelector(this.dataset.target);
    console.log('target', target);

    this.classList.toggle('animate-collapsed');
    target.classList.toggle('hidden');
};

initAnimations();
