/**
 * Map
 */
var mapModal, mapAdmin, locationInput, mapImage, mapImageOriginalWidth;
var mapPositionX, mapPositionY;
var mapZoomIn, mapZoomOut, mapZoomReset;
var mapToggleShow, mapToggleHide;
var mapZoomValue = 100, mapZoomIncrements = 0;
var mapDraggable, mapIsMoving = false, mapPointIsMoving = false;
var mapPointModalBody;

// V2
var mapElement, mapPanel, mapPanelLoader;
var mapAdminMode, mapViewMode, mapAdminModeActivated = false;

$(document).ready(function() {
    // Look for a form to save
    mapAdmin = $('#location-map-admin');
    mapPanel = $('#location-map-panel');
    mapPanelLoader = $('#location-map-panel-loading');
    mapModal = $('#point-location');
    locationInput = $('#location_id');

    mapImage = $('#location-map-image');
    mapZoomIn = $('#map-zoom-in');
    mapZoomOut = $('#map-zoom-out');
    mapZoomReset = $('#map-zoom-reset');
    mapToggleHide = $('#map-toggle-hide');
    mapToggleShow = $('#map-toggle-show');

    mapPointModalBody = $('#map-point-body');
    mapDraggable = $('#draggable-map');

    mapAdminMode = $('#map-admin-mode');
    mapViewMode = $('#map-view-mode');
    mapElement = $('.map');

    if (mapAdmin.length === 1) {
        initMapAdmin();
    }

    initMapControls();
    initPointClick();
    initMapModeSwitch();
    initMovePoints();
    disableMovePoints();
    initAddPoints();
    initMapScroll();
});

/**
 * Init Clicking on the Map
 */
function initMapAdmin() {
    var mapModalSubmit = $('#point-location-submit');
    mapModalSubmit.on('click', function(e) {
        // Check that a location was selected
        if (locationInput.val()) {
            mapAdmin.append(
                '<div class="point admin" style="top:' + mapPositionY + 'px;left:' + mapPositionX + 'px">' +
                '<input type="hidden" name="map_point[]" value="' + mapPositionX + '-' + mapPositionY + '-' + locationInput.val() + '" />' +
                '</div>'
            );
            mapModal.modal('toggle');
        } else {

        }
    });

    // Handle deleting already loaded points
    initPointClick();
}

/**
 * Register click on the map zoom controls
 */
function initMapControls() {
    if (mapDraggable.length === 1) {
        $('#draggable-map').draggable({
            drag: function () {
                mapIsMoving = true;
            },
            stop: function () {
                // Don't update right away, this is a small hack to make sure we're not loading map points when moving
                setTimeout(function() {
                    mapIsMoving = false;
                }, 200);
            }
        });
    }

    if (mapZoomIn.length === 1) {
        mapZoomIn.on('click', function (e) {
            e.preventDefault();
            mapZoom(25);
        });
        mapZoomOut.on('click', function (e) {
            e.preventDefault();
            mapZoom(-25);
        });
        mapZoomReset.on('click', function (e) {
            e.preventDefault();
            mapZoomValue = 100;
            mapZoom(0);
        });
        mapToggleHide.on('click', function (e) {
            e.preventDefault();
            mapTogglePoints(false);
        });
        mapToggleShow.on('click', function (e) {
            e.preventDefault();
            mapTogglePoints(true);
        });
    }
}

/**
 * Zoom on the map
 * @param change
 * @returns {boolean}
 */
function mapZoom(change) {
    // Don't have the size yet? Calculate it. We don't calc on page load because if it's on a hidden tab,
    // it evaluates to 0
    var min = 10;
    var max = 300;

    if (!mapImageOriginalWidth) {
        mapImageOriginalWidth = mapImage.width();
    }
    // Min/Max
    var newZoom = mapZoomValue + change;
    if (newZoom > max || newZoom < min) {
        return false;
    }

    mapZoomOut.removeAttr('disabled');
    mapZoomIn.removeAttr('disabled');
    mapZoomValue = newZoom;

    magnifier = (mapZoomValue / 100);
    mapImage.width(mapImageOriginalWidth * magnifier);

    if (change > 0) {
        mapZoomIncrements++;
    } else {
        mapZoomIncrements--;
    }

    $.each($('.point'), function() {
        repositionPoint($(this), magnifier);
    });

    if (mapZoomValue <= min) {
        mapZoomOut.attr('disabled', 'disabled');
    } else if (newZoom >= max) {
        mapZoomIn.attr('disabled', 'disabled');
    }
}

/**
 * Add update click on all points
 */
function initPointClick() {
    $.each($('.point'), function (index) {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function(e) {
            if (mapPointIsMoving === true) {
                return;
            }

            e.preventDefault();
            loadMapPoint($(this));
        });
    });
}


/**
 * This is re-defined (copy-paste) from app.js, since the minify changes the original name
 */
function initSelect2() {
    if ($('.select2').length > 0) {
        $.each($('.select2'), function (index) {

            $(this).select2({
//            data: newOptions,
                placeholder: $(this).attr('data-placeholder'),
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    quietMillis: 200,
                    url: $(this).attr('data-url'),
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    }
}

/**
 * Toggle showing or hiding of points on the map
 * @param show
 */
function mapTogglePoints(show) {
    if (show) {
        mapToggleHide.show();
        mapToggleShow.hide();

        $.each($('.map .point'), function() {
            $(this).show();
        });
    } else {
        mapToggleHide.hide();
        mapToggleShow.show();

        $.each($('.map .point'), function() {
            $(this).hide();
        });
    }
}

/**
 * V2
 */

/**
 * Load a map point into the side panel
 * @param element
 */
function loadMapPoint(element) {
    if (mapIsMoving === true || mapPointIsMoving === true) {
        return;
    }

    // Admin mode? Load the form modal
    if (mapAdminModeActivated) {
        $.ajax({
            url: element.data('url-modal')
        }).done(function (result, textStatus, xhr) {
            if (result) {
                mapPointModalBody.html(result);
                initModalForm();
                mapModal.modal();
            }
        }).fail(function (result, textStatus, xhr) {
            console.log('map point error', result);
        });

        return;
    }

    mapPanelLoader.show();
    mapPanel.html('');

    $.ajax(
        element.data('url')
    ).done(function(data) {
        mapPanelLoader.hide();
        mapPanel.html(data);
    });
}

/**
 * Switch between Admin and View Mode
 */
function initMapModeSwitch() {
    mapAdminMode.click(function(e) {
        $(this).hide();
        mapAdminModeActivated = true;
        mapViewMode.show();
        mapElement.addClass('map-admin-mode');

        activateMovePoints();
    });

    mapViewMode.click(function(e) {
        $(this).hide();
        mapAdminModeActivated = false;
        mapAdminMode.show();
        mapElement.removeClass('map-admin-mode');

        disableMovePoints();
    });
}

/**
 * Open the modal to add a map point
 */
function initAddPoints() {
    mapImage.click(function(e) {
        if (mapAdminModeActivated === false) {
            return;
        }

        // Don't click if moving
        if (mapPointIsMoving === true || mapIsMoving === true) {
            return;
        }

        var offset = $(this).offset();
        mapPositionX = e.pageX - offset.left - 25;
        mapPositionY = e.pageY - offset.top - 25;

        // Don't allow negative positions
        if (mapPositionX < 0) {
            mapPositionX = 0;
        }
        if (mapPositionY < 0) {
            mapPositionY = 0;
        }

        // Need to adapt the map position to the magnifier to know where we really are.
        magnifier = (mapZoomValue / 100);
        mapPositionY = parseInt(mapPositionY) / magnifier;
        mapPositionX = parseInt(mapPositionX) / magnifier;

        $.ajax({
            url: $(this).data('url') + '?axis_y=' + parseInt(mapPositionY) + '&axis_x=' + parseInt(mapPositionX)
        }).done(function (result, textStatus, xhr) {
            if (result) {
                mapPointModalBody.html(result);
                initModalForm();
                mapModal.modal();
            }
        }).fail(function (result, textStatus, xhr) {
            console.log('map point error', result);
        });
    });
}

/**
 *
 */
function initMovePoints() {
    $.each($('.point'), function(index) {
        addPointMove($(this));
    });
}

/**
 * Enable dragging map points
 */
function activateMovePoints() {
    $.each($('.point'), function(index) {
        $(this).draggable({disabled: false});
    });
}

/**
 * Disable draggin map points
 */
function disableMovePoints() {
    $.each($('.point'), function(index) {
        $(this).draggable({disabled: true});
    });
}

/**
 * Add movable points
 * @param point
 */
function addPointMove(point) {
    point.draggable({
        revert: false,
        start: function(event, ui) {
            console.log('start moving point');
            mapPointIsMoving = true;
        },
        stop: function (event, ui) {
            // event.preventDefault();
            var location = $(event.target);

            var offset = mapImage.offset();
            var pointOffset = parseInt($(this).data('size') / 2);
            console.log('point offset', pointOffset);

            // Determine the offset between the mouse and the object's top left
            console.log('mouse x y', event.pageX, event.pageY);
            console.log('block x y', ui);

            mapPositionX = ui.position.left;
            mapPositionY = ui.position.top;

            // Recalculate position based on zoom
            magnifier = (mapZoomValue / 100);
            mapPositionX = mapPositionX / magnifier;
            mapPositionY = mapPositionY / magnifier;

            console.log('stop moving');

            $.ajax({
                url: location.attr('data-url-move') + '?axis_x=' + mapPositionX + '&axis_y=' + mapPositionY
            }).done(function (result, textStatus, xhr) {
                //event.preventDefault();

                // console.log('finished moving point');
                mapPointIsMoving = false;
            }).fail(function (result, textStatus, xhr) {
                // console.log('map point error', result);
                mapPointIsMoving = false;
            });

            //$(this).removeClass('ui-draggable-dragging');

            return true;
        }
    });
}

/**
 * Modal form submit catcher
 */
function initModalForm() {
    initSelect2();
    initDeleteMapPoint();
    $('.map-point-form').submit(function (e) {
        var formData = $(this).serialize();

        $.ajax({
            type        : $(this).attr('method'),
            url         : $(this).attr('action'),
            data        : formData,
            dataType    : 'json',
            encode          : true
        }).done(function (data) {
            mapModal.modal('hide');
            if (data.point) {
                // Remove existing one?
                console.log('data id', data.id);
                var existing = $('#' + data.id);
                if (existing.length === 1) {
                    existing.remove();
                }

                $('.map-container').append(data.point);
                initPointClick();

                // Make the new point movable and add tooltip
                newPoint = $('#' + data.id);
                addPointMove(newPoint);

                magnifier = (mapZoomValue / 100);
                repositionPoint(newPoint, magnifier);

                newPoint.tooltip();
            }

        }).fail(function (data) {
            console.log('fail', data);
            if (data.responseJSON.errors) {
                $('.location-map-errors').html(buildErrors(data.responseJSON.errors)).fadeIn();
            }
        });

        event.preventDefault();
    });
}

/**
 *
 */
function initDeleteMapPoint() {
    $('.map-point-delete').each(function() {
        $(this).click(function(e) {
            url = $(this).data('url');
            console.log('delete', url);
            e.preventDefault();

            // Allow ajax requests to use the X_CSRF_TOKEN for deletes
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post({
                url: url,
                dataType: 'json',
                data: {
                    '_method': 'DELETE'
                },
                context: this
            }).done(function (result, textStatus, xhr) {
                console.log('finished destroying');
                // Hide this
                if (result.id) {
                    $('#' + result.id).remove();
                }
                mapModal.modal('hide');
            });

            return false;
        });
    });
}

/**
 *
 * @param data
 * @returns {string}
 */
function buildErrors(data) {
    var errors = '';
    for (var key in data) {
        // skip loop if the property is from prototype
        if (!data.hasOwnProperty(key)) continue;

        errors += data[key] + "<br>";
    }
    return errors;
}

/**
 * Handle scroll
 */
function initMapScroll() {
    $(window).bind('mousewheel DOMMouseScroll', function(event) {
        if (event.ctrlKey == true) {
            event.preventDefault();
            if (event.originalEvent.wheelDelta < 0) {
                mapZoom(-10);
            } else {
                mapZoom(10);
            }
        }
    });
}

/**
 * Reposition a point on the map
 * @param point
 * @param magnifier
 */
function repositionPoint(point, magnifier) {
    point.css('top', (point.data('top') * magnifier) + 'px');
    point.css('left', (point.data('left') * magnifier)+ 'px');
    point.css('width', (point.data('size') * magnifier)+ 'px');
    point.css('height', (point.data('size')  * magnifier)+ 'px');
    //$(this).css('border-radius', (25 * magnifier)+ 'px');

    fontSize = 24;
    if (point.data('size') === 25) {
        fontSize = 12;
    } else if (point.data('size') === 100) {
        fontSize = 56;
    }
    point.css('font-size', (fontSize * magnifier) + 'px');
}
