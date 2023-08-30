const multiEditingModal = document.querySelector('dialog#edit-warning');
const keepAliveTimer = 300 * 1000; // 5 minutes
let keepAliveUrl;
let keepAliveEnabled = true;

$(document).ready(function () {
    if (!multiEditingModal) {
        return;
    }

    let config = document.querySelector('input[name="edit-warning"]');
    window.openDialog('edit-warning', config.dataset.url);

    $(document).on('shown.bs.modal', function () {
        registerEditWarning();
    });
    registerEditKeepAlive();
});

/**
 *
 */
function registerEditWarning() {
    // Don't enable keep alive until the user has confirmed
    keepAliveEnabled = false;

    // Handle clicks
    $('#entity-edit-warning-ignore').click(function (e) {
        e.preventDefault();
        keepAliveEnabled = true;

        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            context: this
        }).done(function () {
            multiEditingModal.close();
        });
    });
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
