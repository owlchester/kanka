var multiEditingModal;
var keepAliveTimer = 300 * 1000; // 5 minutes
var keepAliveUrl;
var keepAliveEnabled = true;

$(document).ready(function () {
    multiEditingModal = $('#entity-edit-warning');
    if (multiEditingModal.length === 0) {
        return;
    }

    registerEditWarning();
    registerEditKeepAlive();
});

/**
 *
 */
function registerEditWarning() {
    // Don't enable keep alive until the user has confirmed
    keepAliveEnabled = false;
    multiEditingModal.modal({
        backdrop: false
    });

    // Handle clicks
    $('#entity-edit-warning-ignore').click(function (e) {
        e.preventDefault();
        confirmEditWarningModal();
        keepAliveEnabled = true;

        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            context: this
        }).done(function () {
            multiEditingModal.modal('hide');
        });
    });

    $('#entity-edit-warning-back').click(function (e) {
        e.preventDefault();
        confirmEditWarningModal();
        window.location.href = $(this).data('url');
    });
}

function confirmEditWarningModal() {
    multiEditingModal.find('.modal-ajax-body').hide();
    multiEditingModal.find('.modal-spinner-body').show();
    multiEditingModal.find('.modal-footer').hide();
}

/**
 * Set up the keep alive pulse configuration
 */
function registerEditKeepAlive() {
    let field = $('#editing-keep-alive');
    if (field.length === 0) {
        return;
    }
    keepAliveUrl = field.data('url');

    setTimeout(keepAlivePulse, keepAliveTimer);
}

/**
 * Send a pulse to the backend that the user is still editing the entity
 */
function keepAlivePulse() {
    if (!keepAliveEnabled) {
        setTimeout(keepAlivePulse, keepAliveTimer);
        return;
    }

    $.ajax({
        url: keepAliveUrl,
        type: 'POST'
    })
    .done(function() {
        //console.log('kept alive');
        setTimeout(keepAlivePulse, keepAliveTimer);
    });
}
