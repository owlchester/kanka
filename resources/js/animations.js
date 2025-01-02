const initAnimations = () => {
    const collapsers = document.querySelectorAll('[data-animate="collapse"]');
    collapsers.forEach((e) => {
        e.addEventListener('click', toggle);
    });

    const revelers = document.querySelectorAll('[data-animate="reveal"]');
    revelers.forEach((e) => {
        e.addEventListener('change', change);
    });

    const pulses = document.querySelectorAll('[data-pulse]');
    pulses.forEach((e) => {
        e.addEventListener('click', clickWelcomePulse);
    });
};

const clickWelcomePulse = (e) => {
    e.preventDefault();
    let target = document.querySelector(e.currentTarget.dataset.pulse);
    let content = e.currentTarget.dataset.content;

    window.showTooltip(target, {
        content: content,
        theme: 'kanka',
        placement: e.currentTarget.dataset.placement ?? 'bottom',
        allowHTML: true,
        arrow: true,
        interactive: true,
        trigger: 'manual',
    });
};

function toggle(e) {
    if (e.target.type !== 'checkbox') {
        e.preventDefault();
    }

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
