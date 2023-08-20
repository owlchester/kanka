window.onload = function (event) {
    console.log('loaded');
    const wrapper = document.getElementById('nav-mobile-toggler');
    console.debug(wrapper);

    wrapper.addEventListener('click', () => {
        console.debug('clicked');
        wrapper.classList.toggle('open');
    })
}
