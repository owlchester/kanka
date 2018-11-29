/**
 * Dashboard
 */
var newWidget, newWidgetPreview, newWidgetCalendar, newWidgetRecent;
var btnWidgetPreview, btnWidgetCalendar, btnWidgetRecent;

var btnAddWidget;
var modalContentButtons, modalContentTarget, modalContentSpinner;

$(document).ready(function() {

    $.each($('[data-toggle="preview"]'), function(i) {
       // If we are exactly the height of 200, some content is hidden
       if ($(this).height() === 200) {
           $('[data-toggle="preview"]').click(function(e) {
               if ($(this).hasClass('preview')) {
                   $(this).removeClass('preview').addClass('full');
               } else {
                   $(this).removeClass('full').addClass('preview');
               }
           });
       } else {
           $(this).removeClass('pinned-entity preview');
       }
    });
    
    if ($('.campaign-dashboard-widgets').length === 1) {
        initDashboardAdminUI();
    }
});

function initDashboardAdminUI() {
    console.log('init dashboard admin ui');

    newWidget = $('#new-widget');
    newWidgetPreview = $('#new-widget-preview');
    newWidgetCalendar = $('#new-widget-calendar');
    newWidgetRecent = $('#new-widget-recent');
    
    btnWidgetPreview = $('#btn-widget-preview');
    btnWidgetCalendar = $('#btn-widget-calendar');
    btnWidgetRecent = $('#btn-widget-recent');

    btnAddWidget = $('#add-widget');
    modalContentButtons = $('#modal-content-buttons');
    modalContentTarget = $('#modal-content-target');
    modalContentSpinner = $('#modal-content-spinner');

    btnWidgetPreview.click(function(e) {
        console.log('click widget preview');
        loadModalForm($(this).data('url'));
    });

    btnWidgetCalendar.click(function(e) {
        console.log('click widget calendar');
        loadModalForm($(this).data('url'));
    });

    // Reset the modal
    btnAddWidget.click(function(e) {
        modalContentSpinner.hide();
        modalContentTarget.html('');
        modalContentButtons.show();
    });
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
    });
}