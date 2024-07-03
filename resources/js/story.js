
window.onEvent(function() {
    initImageFocus();
 });

let bullseye;
let scaledImage;

const initImageFocus = () => {
    bullseye = document.querySelector('.focus');
    scaledImage = document.querySelector('.focus-image');
    if (!scaledImage) {
        return;
    }

    scaledImage.addEventListener('click', function (e) {
        // Get the original dimensions of the image
        const originalWidth = scaledImage.naturalWidth;
        const originalHeight = scaledImage.naturalHeight;

        // Get the click coordinates
        const clickX = e.clientX - scaledImage.getBoundingClientRect().left;
        const clickY = e.clientY - scaledImage.getBoundingClientRect().top;

        // Calculate the coordinates with respect to the original size
        const originalX = (clickX / scaledImage.clientWidth) * originalWidth;
        const originalY = (clickY / scaledImage.clientHeight) * originalHeight;

        // Calculate the coordinates as a percentage, so that the focus point can be placed correctly to scale
        const percentageX = (originalX / originalWidth) * 100;
        const percentageY = (originalY / originalHeight) * 100;

        drawBullseye(percentageY, percentageX);
        document.querySelector('input[name="focus_x"]').value = parseInt(originalX);
        document.querySelector('input[name="focus_y"]').value = parseInt(originalY);
    });

    bullseye.addEventListener('click', function () {
        bullseye.style.display = 'none';
        document.querySelector('input[name="focus_x"]').value = '';
        document.querySelector('input[name="focus_y"]').value = '';
    });

    // Place the bullseye on the page
    if (bullseye.dataset.focusX && bullseye.dataset.focusY) {
        // Get the original dimensions of the image
        const originalWidth = scaledImage.naturalWidth;
        const originalHeight = scaledImage.naturalHeight;

        // Calculate the coordinates as a percentage, so that the focus point can be placed correctly to scale
        const left = (bullseye.dataset.focusX / originalWidth) * 100;
        const top = (bullseye.dataset.focusY / originalHeight) * 100;

        drawBullseye(top, left);
    }
};

const drawBullseye = (top, left) => {
    bullseye.style.top = (top) + '%';
    bullseye.style.left = (left) + '%';
    bullseye.style.display = 'inherit';
};


initImageFocus();
