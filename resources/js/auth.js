//window.$ = window.jQuery = require('jquery');

    initTogglePasswordFields();
    initFormBlocker();

/**
 * Disable a form to avoid it being submitted twice
 */
function initFormBlocker() {
    let forms = document.getElementsByClassName('submit-lock');
    for (const form of forms) {
        form.onsubmit = function () {
            document.getElementById('btn-save').style.display = 'none';
            document.getElementById('btn-wait').style.display = '';
        };
    }
}

/**
 * Show/Hide password field helpers
 */
function initTogglePasswordFields() {
    let passwordField = document.getElementById('password');
    var passwordToggleIcon = document.getElementById('toggle-password-icon');
    var toggler = document.getElementById('toggle-password');
    if (!toggler) {
        return;
    }
    toggler.onclick = function (e) {
        e.preventDefault();
        if (passwordField.type === 'text') {
            passwordField.type = 'password';
        } else {
            passwordField.type = 'text';
        }
        return false;
    };
}
