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
    const field = document.getElementById('entity-edit-warning-ignore');
    field.addEventListener('click', function (e) {
        e.preventDefault();
        keepAliveEnabled = true;

        axios
            .post(field.dataset.url)
            .then(() => {
                multiEditingModal.close();
            });
    });
}

/**
 * Set up the keep alive pulse configuration
 */
function registerEditKeepAlive() {
    const field = document.getElementById('editing-keep-alive');
    if (!field) {
        return;
    }
    keepAliveUrl = field.dataset.url;
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
