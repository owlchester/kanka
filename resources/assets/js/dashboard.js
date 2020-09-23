/**
 * Dashboard
 */
var newWidget, newWidgetPreview, newWidgetCalendar, newWidgetRecent;
var btnWidgetPreview, btnWidgetCalendar, btnWidgetRecent;

var btnAddWidget;
var modalContentButtons, modalContentTarget, modalContentSpinner;

$(document).ready(function() {

    $('.preview-switch').click(function(e) {
        e.preventDefault();

        var preview = $('#widget-preview-body-' + $(this).data('widget'));
        if (preview.hasClass('preview')) {
            preview.removeClass('preview').addClass('full');
            $(this).html('<i class="fa fa-chevron-up"></i>');
        } else {
            preview.removeClass('full').addClass('preview');
            $(this).html('<i class="fa fa-chevron-down"></i>');
        }

    });

    $.each($('[data-toggle="preview"]'), function(i) {
        // If we are exactly the max-height, some content is hidden
        // console.log('compare', $(this).height(), 'vs', $(this).css('max-height'));
        if ($(this).height() === parseInt($(this).css('max-height'))) {
            $(this).next().removeClass('hidden')
        } else {
            $(this).removeClass('pinned-entity preview');
        }
    });

    $.each($('[data-widget="remove"]'), function(i) {
        $(this).click(function(e) {
            $.post({
                url: $(this).data('url'),
                method: 'POST',
            }).done(function(data) {
            });
        });
    });

    // Ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('.campaign-dashboard-widgets').length === 1) {
        initDashboardAdminUI();
    }

    initDashboardRecent();
    initDashboardCalendars();
    initFollow();
});

/**
 *
 */
function initDashboardAdminUI() {
    newWidget = $('#new-widget');
    newWidgetPreview = $('#new-widget-preview');
    newWidgetCalendar = $('#new-widget-calendar');
    newWidgetRecent = $('#new-widget-recent');

    btnWidgetPreview = $('#btn-widget-preview');
    btnWidgetCalendar = $('#btn-widget-calendar');
    btnWidgetRecent = $('#btn-widget-recent');

    btnAddWidget = $('#btn-add-widget');
    modalContentButtons = $('#modal-content-buttons');
    modalContentTarget = $('#modal-content-target');
    modalContentSpinner = $('#modal-content-spinner');

    $('.btn-lg').click(function(e) {
        loadModalForm($(this).data('url'));
    });

    // Reset the modal
    btnAddWidget.click(function(e) {
        modalContentSpinner.hide();
        modalContentTarget.html('');
        modalContentButtons.show();
    });

    $('#widgets').sortable({
        items: '.widget-draggable',
        stop: function(event, ui) {
            // Allow ajax requests to use the X_CSRF_TOKEN for deletes
            $.post({
                url: $('#widgets').data('url'),
                dataType: 'json',
                data: $('input[name="widgets[]"]').serialize()
            }).done(function(data) {

            });
        }
    });
    //$('#widgets').disableSelection();
}

/**
 * Load widget subform in modal
 * @param url
 */
function loadModalForm(url) {
    modalContentButtons.fadeOut(400, function() {
        modalContentSpinner.fadeIn();
    });

    $.ajax(url).done(function(data) {
        modalContentSpinner.hide();
        modalContentTarget.html(data);

        window.initSelect2();
        window.initCategories();
    });
}

/**
 *
 */
function initDashboardRecent()
{
    $('.widget-recent-more').click(function(e) {
        e.preventDefault();
        $(this).html('<i class="fa fa-spin fa-spinner"></i>');

        $.ajax({
            url: $(this).data('url'),
            context: this
        }).done(function(data) {
            $(this).closest('.widget-recent-list').append(data);
            $(this).remove();

            initDashboardRecent();
            window.ajaxTooltip();

            // Reload tooltips
            // Inject the isMobile variable into the window. We don't want ALL of the javascript
            // for mobiles, namely the tooltip tool.
            // window.kankaIsMobile = window.matchMedia("only screen and (max-width: 760px)");
            // if (!window.kankaIsMobile.matches) {
            //     $('[data-toggle="tooltip"]').tooltip();
            // }

        });
    });
}

/**
 *
 */
function initDashboardCalendars()
{
    $('.widget-calendar-switch').click(function(e) {
        console.log('click calendar switch');
        var url = $(this).data('url'),
            widget = $(this).data('widget');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#widget-date-' + widget).addClass('hidden');
        $('#widget-loading-' + widget).removeClass('hidden').siblings('.row').addClass('hidden');

        $.ajax({
            url: url,
            method: 'POST',
            context: this
        }).done(function(data) {
            if (data) {
                // Redirect page
                var widget = $(this).data('widget');
                $('#widget-body-' + widget).html(data);
                initDashboardCalendars();
            }
        });
    });
}

/**
 * Follow / Unfollow a campaign
 */
function initFollow()
{
    var btn = $('#campaign-follow');
    var text = $('#campaign-follow-text');

    if (btn.length !== 1) {
        return;
    }

    var status = btn.data('following');
    if (status) {
        text.html(btn.data('unfollow'));
    } else {
        text.html(btn.data('follow'));
    }
    btn.show();

    btn.click(function (e) {
        e.preventDefault();

        $.post({
            url: $(this).data('url'),
            method: 'POST'
        }).done(function(data) {
            if (data.following) {
                text.html(btn.data('unfollow'));
            } else {
                text.html(btn.data('follow'));
            }
        });
    });
}
