import deleteConfirm from "../components/delete-confirm";

var mapPageBody;
var sidebarMap, sidebarMarker;
var markerModal, markerModalContent, markerModalTitle;
var validEntityForm = false;

var validSubform = false;
var subForm;
var currentAjaxForm;

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

/**
 *
 */
function initMapExplore()
{
    //console.log('initMapExplore', '');
    mapPageBody = $('#map-body');
    if (mapPageBody.length === 0) {
        //console.log('initMapExplore', 'no explore mode');
        return;
    }
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
                if (result) {
                    if (window.kankaIsMobile.matches) {
                        markerModalTitle.html(result.name);
                        markerModalContent.html(result.body);
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

    initLegend();
    initMapEntryClick();

    $(document).one('shown.bs.modal shown.bs.popover', function() {
        //console.warn('modal show or popover');
        initSubforms();
    });
}

/**
 * When submitting the layer or marker form from the map modal, disable the map form unsaved changed
 * alert.
 */
function initMapForms()
{
    //console.info('mapsv3', 'initMapForms');
    let layerForm = $('#map-layer-form');
    let markerForm = $('#map-marker-form');
    let groupForm = $('#map-group-form');
    if ($('#entity-form').length === 0 && $('.map-marker-edit-form').length === 0) {
        //console.info('initMapForms empty');
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

    $('select[name="size_id"]').change(function (e) {
        if (this.value == 6) {
            $('.map-marker-circle-helper').hide();
            $('.map-marker-circle-radius').show();
        } else {
            $('.map-marker-circle-radius').hide();
            $('.map-marker-circle-helper').show();
        }
    });

    $(document).on('shown.bs.modal shown.bs.popover', function(e) {
        //console.warn('modal show or popover');
        initSubforms();
        e.stopPropagation();
    });

    initLegend();
    initMapEntryClick();
}

function initSubforms()
{
    //console.info('initSubforms');
    subForm = $('.ajax-subform');
    if (subForm.length === 0) {
        //console.info('not ajax subforms');
        return;
    }

    subForm.one('submit', function(e) {
        //console.info('ajax-subform submit');
        if (validSubform) {
            //console.info('ajax-subform real submit');
            return true;
        }

        currentAjaxForm = $(this);

        window.entityFormHasUnsavedChanges = false;
        e.preventDefault();

        $(this).find('.form-submit-main span').hide();
        $(this).find('.form-submit-main i.fa').show();

        // Allow ajax requests to use the X_CSRF_TOKEN for deletes
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (res) {
            // If the validation succeeded, we can really submit the form
            validSubform = true;
            currentAjaxForm.submit();
            return true;
        }).fail(function (err) {
            //console.log('error', err);
            // Reset any error fields
            currentAjaxForm.find('.input-error').removeClass('input-error');
            currentAjaxForm.find('.text-danger').remove();

            // If we have a 503 error status, let's assume it's from cloudflare and help the user
            // properly save their data.
            if (err.status === 503) {
                $('#entity-form-503-error').show();
                resetSubformSubmitAnimation();
            }

            // If it's 403, the session is gone
            if (err.status === 403) {
                $('#entity-form-403-error').show();
                resetSubformSubmitAnimation();
            }

            // Loop through the errors to add the class and error message
            let errors = err.responseJSON.errors;

            let errorKeys = Object.keys(errors);
            let foundAllErrors = true;
            errorKeys.forEach(function (i) {
                let errorSelector = $('[name="' + i + '"]');
                //console.log('error field', '[name="' + i + '"]');
                if (errorSelector.length > 0) {
                    currentAjaxForm.find('[name="' + i + '"]').addClass('input-error')
                        .parent()
                        .append('<div class="text-danger">' + errors[i][0] + '</div>');
                } else {
                    foundAllErrors = false;
                }
            });

            let firstItem = Object.keys(errors)[0];
            let firstItemDom = subForm.find('[name="' + firstItem + '"]');

            // If we can actually find the first element, switch to it and the correct tab.
            if (firstItemDom.length > 0) {
                firstItemDom.focus();
            }

            // Reset submit buttons
            resetSubformSubmitAnimation();

            //console.log('reset stuff');
            currentAjaxForm.find('.form-submit-main i.fa').hide();
            currentAjaxForm.find('.form-submit-main span').show();
        });
    });
}

function resetSubformSubmitAnimation()
{
    let submitBtn = subForm.find('.btn-success');
    if (submitBtn.length > 0) {
        $.each(submitBtn, function () {
            $(this).removeAttr('disabled');
            if ($(this).data('reset')) {
                $(this).html($(this).data('reset'));
            }
        });
    }
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

function initLegend()
{
    $('.map-legend-marker').click(function (ev) {
        ev.preventDefault();
        window.map.panTo(L.latLng($(this).data('lat'), $(this).data('lng')));
        window[$(this).data('id')].openPopup();
    });
}
function initMapEntryClick() {
    $('.map-marker-entry-click').click(function (e) {
        e.preventDefault();
        $(this).parent().hide();
        $('.map-marker-entry-entry').show();
    });

}
