import deleteConfirm from "../components/delete-confirm";

var mapPageBody;
var sidebarMap, sidebarMarker;
var markerModal, markerModalContent, markerModalTitle;
var validEntityForm = false;

$(document).ready(function() {

    window.map.invalidateSize();
    //deleteConfirm();

    window.map.on('popupopen', function (ev) {
        deleteConfirm();
    });

    // Event fired when clicking on an existing map point

    $('a[href="#marker-pin"]').click(function (e) {
        $('input[name="shape_id"]').val(1);
    });
    $('a[href="#marker-label"]').click(function (e) {
        $('input[name="shape_id"]').val(2);
    });
    $('a[href="#marker-circle"]').click(function (e) {
        $('input[name="shape_id"]').val(3);
    });
    $('a[href="#marker-poly"]').click(function (e) {
        $('input[name="shape_id"]').val(5);
    });
    $('a[href="#form-markers"]').click(function (e) {
        window.map.invalidateSize();
    });

    initMapExplore();
    initMapForms();

    // Limit the size of custom svg icons to not overblow the marker size
    // $('.map .custom-icon svg').each(function (e) {
    //     $(this).attr("height", 32).attr("width", 32).css('margin-top', '4px');
    // });
});

$(document).on('shown.bs.modal shown.bs.popover', function() {
    initMapForms();
});

/**
 *
 */
function initMapExplore()
{
    mapPageBody = $('#map-body');
    sidebarMap = $('#sidebar-map');
    sidebarMarker = $('#sidebar-marker');
    markerModal = $('#map-marker-modal');
    markerModalTitle = $('#map-marker-modal-title');
    markerModalContent = $('#map-marker-modal-content');

    // Allow ajax requests to use the X_CSRF_TOKEN for moves
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.markerDetails = function(url)
    {
        showSidebar();
        if (window.kankaIsMobile.matches) {
            url = url + '?mobile=1'
        }
        $.ajax({
            url: url,
            type: 'GET',
            async: true,
            success: function (result) {
                // console.log('result');
                if (result) {
                    if (window.kankaIsMobile.matches) {
                        console.log('mobile result');
                        markerModalTitle.html(result.name);
                        markerModalContent.html(result.body);
                        console.log('markerModal', markerModal);
                    } else {
                        sidebarMarker.html(result.body);
                        handleCloseMarker();
                        mapPageBody.addClass('sidebar-open');
                    }
                    deleteConfirm();
                }
            }
        })
    }

    $('.map-legend-marker').click(function (ev) {
        ev.preventDefault();
        window.map.panTo(L.latLng($(this).data('lat'), $(this).data('lng')));
        window[$(this).data('id')].openPopup();
    });
}

/**
 * When submitting the layer or marker form from the map modal, disable the map form unsaved changed
 * alert.
 */
function initMapForms()
{
    let layerForm = $('#map-layer-form');
    let markerForm = $('#map-marker-form');
    let newMarkerForm = $('#map-marker-new-form');
    let groupForm = $('#map-group-form');
    if (layerForm.length === 0 && markerForm.length === 0 && groupForm.length === 0 && newMarkerForm.length === 0) {
        console.log('found nothing');
        return;
    }

    layerForm.unbind('submit').on('submit', function() {
        window.entityFormHasUnsavedChanges = false;
    });
    markerForm.unbind('submit').on('submit', function() {
        window.entityFormHasUnsavedChanges = false;
    });
    groupForm.unbind('submit').on('submit', function() {
        window.entityFormHasUnsavedChanges = false;
    });

    newMarkerForm.unbind('submit').on('submit', function(e) {
        window.entityFormHasUnsavedChanges = false;
        if (validEntityForm) {
            return true;
        }

        e.preventDefault();

        // Allow ajax requests to use the X_CSRF_TOKEN for deletes
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#map-marker-new-form .btn-success span').hide();
        $('#map-marker-new-form .btn-success i.fa').show();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (res) {
            //console.log('good?');
            // If the validation succeeded, we can really submit the form
            validEntityForm = true;
            newMarkerForm.submit();
            return true;
        }).fail(function (err) {
            console.log('error', err);
            // Reset any error fields
            //$('.input-error').removeClass('input-error');
            //$('.text-danger').remove();

            // Loop through the errors to add the class and error message
            var errors = err.responseJSON.errors;

            var errorKeys = Object.keys(errors);
            var foundAllErrors = true;
            errorKeys.forEach(function (i) {
                var errorSelector = $('[name="' + i + '"]');
                if (errorSelector.length > 0) {
                    if (!errorSelector.hasClass('input-error')) {
                        errorSelector.addClass('input-error').parent().append('<div class="text-danger">' + errors[i][0] + '</div>');
                    }
                } else {
                    foundAllErrors = false;
                }
            });

            $('#map-marker-new-form .btn-success span').show();
            $('#map-marker-new-form .btn-success i.fa').hide();
        });
    })
}


function showSidebar()
{
    let spinner = '<div class="text-center"><i class="fa fa-spin fa-spinner fa-2x"></i></div>';

    // On mobile use the modal instead of the sidebar
    if (window.kankaIsMobile.matches) {
        markerModalContent.html(spinner)
        markerModal.modal('toggle');
        return;
    }

    //window.map.invalidateSize();
    mapPageBody.removeClass('sidebar-collapse').addClass('sidebar-open');
    sidebarMap.hide();
    sidebarMarker.show().html(spinner);
}

function handleCloseMarker()
{
    $('.marker-close').click(function (ev) {
        sidebarMarker.hide();
        sidebarMap.show();
    });
}
