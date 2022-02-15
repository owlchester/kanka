var tutorialModal;

$(document).ready(function () {
    initTutorialModals();
});

function initTutorialModals() {
    tutorialModal = $('#tutorial-modal');
    tutorialModal.modal('show');

    // Handle the various buttons
    initTutorialButtons();
}

function initTutorialButtons() {
    $('[data-tutorial="disable"]').unbind('click').on('click', function(e) {
        e.preventDefault();
        tutorialDisable($(this));
    });

    $('[data-tutorial="next"]').unbind('click').on('click', function(e) {
        e.preventDefault();
        tutorialNext($(this));
    });

    $('[data-tutorial="close"]').unbind('click').on('click', function(e) {
        e.preventDefault();
        closeTutorialModal();
    });
}

function tutorialLoading() {
    tutorialModal.find('.modal-content').first().html(
        '<div class="modal-body text-center">' +
        '<i class="fa fa-spin fa-spinner fa-4x"></i>' +
        '</div>'
    );
}

function closeTutorialModal() {
    tutorialModal.modal('toggle');
}

function tutorialDisable(element) {
    console.log('disable all tutorials');
    tutorialLoading();

    $.ajax({
        url: element.data('url')
    }).done(function () {
        closeTutorialModal();
    }).fail(function () {
        closeTutorialModal();
    });
}

function tutorialNext(element) {
    console.log('next');
    tutorialLoading();

    $.ajax({
        url: element.data('url')
    }).done(function (data) {
        if (!data.html) {
            if (data.highlight) {
                console.log('highlight', data.highlight);
                $(data.highlight).addClass('tutorial-highlight');
            }
            closeTutorialModal();
            return;
        }
        tutorialModal.find('.modal-content').html(
            data.html
        );
        initTutorialButtons();
    });
}
