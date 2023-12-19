$(document).ready(function () {
    initImageFocus();
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        initImageFocus()
     });
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
        let originalWidth = scaledImage.naturalWidth;
        let originalHeight = scaledImage.naturalHeight;

        // Get the click coordinates
        let clickX = e.clientX - scaledImage.getBoundingClientRect().left;
        let clickY = e.clientY - scaledImage.getBoundingClientRect().top;

        // Calculate the coordinates with respect to the original size
        let originalX = (clickX / scaledImage.clientWidth) * originalWidth;
        let originalY = (clickY / scaledImage.clientHeight) * originalHeight;

        // Calculate the coordinates as a percentage, so that the focus point can be placed correctly to scale
        let percentageX = (originalX / originalWidth) * 100;
        let percentageY = (originalY / originalHeight) * 100;

        drawBullseye(percentageY, percentageX);
        $('input[name="focus_x"]').val(parseInt(originalX));
        $('input[name="focus_y"]').val(parseInt(originalY));
    });

    bullseye.addEventListener('click', function () {
        bullseye.style.display = 'none';
        $('input[name="focus_x"]').val("");
        $('input[name="focus_y"]').val("");
    });

    // Place the bullseye on the page
    if (bullseye.dataset.focusX && bullseye.dataset.focusY) {
        // Get the original dimensions of the image
        let originalWidth = scaledImage.naturalWidth;
        let originalHeight = scaledImage.naturalHeight;

        // Calculate the coordinates as a percentage, so that the focus point can be placed correctly to scale
        let left = (bullseye.dataset.focusY / originalWidth) * 100;
        let top = (bullseye.dataset.focusX / originalHeight) * 100;
        drawBullseye(top, left);
    }
};

const drawBullseye = (top, left) => {
    bullseye.style.top = (top) + '%';
    bullseye.style.left = (left) + '%';
    bullseye.style.display = 'inherit';
};
