var quickCreatorModalID = '#entity-modal';
var quickCreatorSubmitBtn;

$(document).ready(function () {
    $(document).on('shown.bs.modal shown.bs.popover', function() {
        quickCreatorUI();
    });

    $('.quick-creator-subform').click(function () {
        $.ajax({
            url: $(this).data('url')
        }).done(function (data) {
            $(quickCreatorModalID).find('.modal-content').show().html(data);
            $(quickCreatorModalID).find('.modal-spinner').hide();
            $(quickCreatorModalID).modal();

            quickCreatorSubformHandler();
        });
    });
});


/**
 * Quick Entity Creator UI
 */
function quickCreatorUI() {
    $('[data-toggle="entity-creator"]').unbind('click').click(function(e) {
        e.preventDefault();

        let type = $(this).data('type');
        if (type === 'inline') {
            $('.quick-creator-body').hide();
            $('.quick-creator-footer').hide();
            $('.quick-creator-loading').show();
        } else {
            quickCreatorLoadingModal();
        }

        $.ajax({
            url: $(this).data('url'),
            context: this
        }).done(function (data) {

            $(quickCreatorModalID).find('.modal-content').show().html(data);
            $(quickCreatorModalID).find('.modal-spinner').hide();

            quickCreatorSubformHandler();
            quickCreatorToggles();
        });

        return false;
    });
}

function quickCreatorDuplicateName() {
    $('#qq-name-field').unbind('focusout').focusout(function() {
        // Don't bother if the user didn't set any value
        if (!$(this).val()) {
            return;
        }

        $(this).parent().parent().find('.duplicate-entity-warning').hide();
        // Check if an entity of the same type already exists, and warn when it does.
        $.ajax({
            'url': $(this).data('live') + '?q=' + $(this).val() + '&type=' + $(this).data('type'),
            context: this
        }).done(function (res) {
            if (res.length > 0) {
                let entities = Object.keys(res).map(function (k) { return '<a href="' + res[k].url + '">' + res[k].name + '</a>'; }).join(', ');
                $(this).parent().parent().find('.duplicate-entities').html(entities);
                $(this).parent().parent().find('.duplicate-entity-warning').fadeIn();
            } else {
                $(this).parent().parent().find('.duplicate-entity-warning').hide();
            }
        });
    });
}

function quickCreatorLoadingModal() {
    $(quickCreatorModalID)
        .find('.modal-content').hide();
    $(quickCreatorModalID)
        .find('.modal-spinner').show();
}

/**
 *
 */
function quickCreatorSubformHandler() {

    quickCreatorSubmitBtn = $('.quick-creator-submit');

    window.initForeignSelect();
    window.initTags();
    quickCreatorDuplicateName();

    // Back button
    quickCreatorBackButton();
    quickCreatorToggles();

    // If we click on edit, we want to be redirected afterwards
    quickCreatorSubmitBtn.on('click', function (e) {
        let action = $(this).data('action');
        if (!action) {
            return true;
        }

        $('#entity-creator-form [name="action"]').val(action);

        return true;
    });

    $('#entity-creator-form').submit(function(e) {

        e.preventDefault();
        quickCreatorSubmitBtn
            .prop('disabled', true)
            .find('span').hide()
            .parent().find('i.fa-spin').show();

        $('div.text-danger').remove();

        $.post({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            context: this
        }).done(function (result) {
            // New entity was created, let's follow that redirect
            //console.log('result', result);
            if (typeof result === 'object') {
                if (result.redirect) {
                    window.location.replace(result.redirect);
                    return;
                }
                let option = new Option(result._name, result._id);
                let field = $('#' + result._target);
                if (result._multi) {
                    let selectedValues = field.val();
                    selectedValues.push(result._id);
                    field.append(option).val(selectedValues);
                } else {
                    field.children().remove().end().append(option).val(result._id);
                }
                field.trigger('change');

                $(quickCreatorModalID).find('.modal-content').html('').show();
                $(quickCreatorModalID).find('.modal-spinner').hide();
                $(quickCreatorModalID).modal('toggle');

                quickCreatorHandleEvents();

                return;
            }

            $(quickCreatorModalID).find('.modal-content').html(result).show();
            $(quickCreatorModalID).find('.modal-spinner').hide();
            quickCreatorUI();
            quickCreatorHandleEvents();

        }).fail(function (err) {
            /** @property {string} responseJSON - json errors from response  */
            if (err.responseJSON.errors) {
                let errors = err.responseJSON.errors;

                let errorKeys = Object.keys(errors);
                let foundAllErrors = true;
                errorKeys.forEach(function (i) {
                    let errorSelector = $('#entity-creator-form [name="' + i + '"]');
                    if (errorSelector.length > 0) {
                        errorSelector.addClass('input-error').parent().append('<div class="text-danger">' + errors[i][0] + '</div>');
                    } else {
                        foundAllErrors = false;
                    }
                });

                let firstItem = Object.keys(errors)[0];
                let firstItemDom = $('#entity-creator-form input[name="' + firstItem + '"]');

                // If we can actually find the first element, switch to it and the correct tab.
                if (firstItemDom[0]) {
                    firstItemDom[0].scrollIntoView({behavior: 'smooth'});

                    // Switch tabs/pane
                    $('.tab-content .active').removeClass('active');
                    $('.nav-tabs li.active').removeClass('active');
                    let firstPane = $('[name="' + firstItem + '"').closest('.tab-pane');
                    firstPane.addClass('active');
                    $('a[href="#' + firstPane.attr('id') + '"]').closest('li').addClass('active');
                }
            }
            quickCreatorSubmitBtn
                .prop('disabled', false)
                .find('i.fa-spin').hide()
                .parent().find('span').show();

            $('#entity-creator-form [name="action"]').val('');
        });
    });
}

function quickCreatorBackButton() {
    $('#entity-creator-back').click(function(e) {
        e.preventDefault();
        quickCreatorLoadingModal();

        $.ajax({
            url: $(this).data('url'),
            context: this
        }).done(function (result) {
            let target = $(this).data('target');
            $(target).find('.modal-content').html(result).show();
            $(target).find('.modal-spinner').hide();
            quickCreatorUI();
        });
    });
}

function quickCreatorToggles() {
    $('.qq-mode-toggle').unbind('click').on('click', function (e) {
        e.preventDefault();

        if ($(this).hasClass('active')) {
            return;
        }

        $('.qq-mode-toggle').removeClass('active');
        $(this).addClass('active');

        $('.quick-creator-body').hide();
        $('.quick-creator-footer').hide();
        $('.quick-creator-loading').show();

        $.ajax({
            url: $(this).data('url')
        })
            .done(function (result) {
                $('#entity-modal').find('.modal-content').html(result).show();
                quickCreatorHandleEvents();
            })
        ;
    });

    $('.qq-action-more').unbind('click').on('click', function (e) {
        e.preventDefault();
        $(this).hide();
        $('.qq-more-fields').show();
    });

    quickCreatorUI();
}

function quickCreatorHandleEvents() {

    quickCreatorToggles();
    quickCreatorDuplicateName();
    quickCreatorBackButton();
    quickCreatorSubformHandler();
    window.initForeignSelect();
    window.initTags();
}
