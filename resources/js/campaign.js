import Sortable from "sortablejs";

$(document).ready(function() {
    registerModules();
    registerUserRoles();
    registerCodeMirror();
    registerSidebarSetup();
    registerRoles();
    registerCampaignThemes();
    registerVanityUrl();
});

/**
 * Register Modules change for campaign settings
 */
function registerModules() {
    if ($('#campaign-modules').length === 0) {
        return;
    }
    $('input[name="enabled"]').change(function (e) {
        e.preventDefault();
        let header = $(this).closest('.box-module').find('h3');
        if (header.hasClass('loading')) {
            return;
        }
        header.addClass('loading');

        axios
            .post($(this).data('url'))
            .then(response => {
                let el = $(this);
                el.closest('.box-module').find('h3').removeClass('loading');
                if (!response.data.success) {
                    return;
                }
                if (response.data.status) {
                    el.closest('.box-module').addClass('module-enabled');
                } else {
                    el.closest('.box-module').removeClass('module-enabled');
                }
                window.showToast(response.data.toast);
        });
    });
}

/**
 * User role admin quick interface
 */
function registerUserRoles() {
    $('.btn-user-roles').popover({
        html: true,
        sanitize: false,
        trigger: 'focus',
    });
}

/** Toggling an action on a permission **/
function registerRoles() {
    let elements = document.querySelectorAll('.public-permission');
    elements.forEach(el => {
        el.addEventListener('click', togglePublicRole);
    });
}

function togglePublicRole(e) {
    e.preventDefault();
    this.classList.add('loading');

    axios.post(this.dataset.url)
        .then(res => {
            this.classList.remove('loading');
            if (res.data.success) {
                if (res.data.status) {
                    $(this).addClass('enabled');
                } else {
                    $(this).removeClass('enabled');
                }
                window.showToast(res.data.toast);
            }
        });
}

/**
 * Initiate codemirror editor in the theming section
 */
function registerCodeMirror() {
    $.each($('.codemirror'), function () {
        let elementID = $(this).attr('id');
        CodeMirror.fromTextArea(document.getElementById(elementID), {
            extraKeys: {"Ctrl-Space": "autocomplete"},
            lineNumbers: true,
            lineWrapping: true,
            theme: 'dracula',
        });
    });
}

function registerSidebarSetup() {
    let nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));

    // Loop through each nested sortable element
    for (let i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            handle: '.dnd-handle',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,

            // Attempt to drag a filtered element
            onMove: function (/**Event*/evt, /**Event*/originalEvent) {
                let self = evt.dragged;
                let target = evt.related;
                // Couldn't figure out how to do this in pure js, so falling back on jQuery
                let targetParentIsFixed = $(target).parents('.fixed-position').length > 0;
                if (self.classList.contains('fixed-position') && targetParentIsFixed) {
                    return false;
                }
                return true;
            },
        });
    }
}


/**
 * Register events for campaign themes, notably the max size of a css field
 */
function registerCampaignThemes() {
    let forms = $('form#campaign-style');
    if (forms.length === 0) {
        return;
    }

    forms.on('submit', function (e) {
        let error = $($(this).data('error'));
        let length = $('textarea[name="content"]').val().length;
        if (length < $(this).data('max-content')) {
            error.hide();
            return true;
        }

        // Show a custom error message to the user
        error.show();

        $('form .submit-group .btn').prop('disabled', false);

        return false;
    });
}

function registerVanityUrl() {
    $('input[name="vanity"]').focusout(function (e) {
        let vanity = $(this).val();
        let errBlock = $('#vanity-error');
        let successBlock = $('#vanity-success');
        let loading = $('#vanity-loading');
        errBlock.html('').hide();
        successBlock.hide();
        if (!vanity) {
            return;
        }

        loading.show();
        let data = {};
        data.vanity = vanity;
        $.post({
            url: $(this).data('url'),
            method: 'POST',
            context: this,
            data: data
        }).done(function (res) {
            $(this).val(res.vanity);
            successBlock.find('code').html(res.vanity);
            successBlock.show();
            errBlock.hide();
            loading.hide();
        }).fail(function (err) {
            //console.error(err);
            let errorString = '';
            err.responseJSON.errors.vanity.forEach(error => errorString += error + ' ');
            errBlock.html(errorString).show();
            successBlock.hide();
            loading.hide();
        });
    });
}
