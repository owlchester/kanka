/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/location/map.js":
/***/ (function(module, exports) {

/**
 * Map
 */
var mapModal, mapAdmin, locationInput, mapImage, mapImageOriginalWidth;
var mapPositionX, mapPositionY;
var mapZoomIn, mapZoomOut, mapZoomReset;
var mapToggleShow, mapToggleHide;
var mapZoomValue = 100,
    mapZoomIncrements = 0;
var mapDraggable,
    mapIsMoving = false,
    mapPointIsMoving = false;
var mapPointModalBody;
var mapMouseX, mapMouseY;

// V2
var mapElement, mapPanel, mapPanelTarget, mapPanelLoader;
var mapAdminMode,
    mapViewMode,
    mapAdminModeActivated = false;
var mapHelper;
var mapEventFirstClick = true;

$(document).ready(function () {
    // Look for a form to save
    mapAdmin = $('#location-map-admin');
    mapPanel = $('#location-map-panel');
    mapPanelTarget = $('#location-map-panel-target');
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
    mapHelper = $('.map-helper');

    initLocationMap();
});

function initLocationMap() {
    // Reset the zoom to the biggest value
    var imgWidth = mapImage.width();

    // If the image hasn't finished loading, let's try again in half a second
    if (!imgWidth || imgWidth === 0) {
        console.log('map', 'waiting another 500 ms for the map to properly load');
        setTimeout('initLocationMap', 500);
        return false;
    }

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
    resizeMapToPage();
}

/**
 * Init Clicking on the Map
 */
function initMapAdmin() {
    var mapModalSubmit = $('#point-location-submit');
    mapModalSubmit.on('click', function (e) {
        // Check that a location was selected
        if (locationInput.val()) {
            mapAdmin.append('<div class="point admin" style="top:' + mapPositionY + 'px;left:' + mapPositionX + 'px">' + '<input type="hidden" name="map_point[]" value="' + mapPositionX + '-' + mapPositionY + '-' + locationInput.val() + '" />' + '</div>');
            mapModal.modal('toggle');
        } else {}
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
            drag: function drag() {
                mapIsMoving = true;
            },
            stop: function stop() {
                // Don't update right away, this is a small hack to make sure we're not loading map points when moving
                setTimeout(function () {
                    mapIsMoving = false;
                }, 200);
            }
        });

        mapDraggable.mousemove(function (event) {
            var offset = mapElement.offset();
            mapMouseX = event.pageX - offset.left;
            mapMouseY = event.pageY - offset.top;
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

    magnifier = mapZoomValue / 100;
    mapImage.width(mapImageOriginalWidth * magnifier);

    if (change > 0) {
        mapZoomIncrements++;
    } else {
        mapZoomIncrements--;
    }

    $.each($('.point'), function () {
        repositionPoint($(this), magnifier);
    });

    if (mapZoomValue <= min) {
        mapZoomOut.attr('disabled', 'disabled');
    } else if (newZoom >= max) {
        mapZoomIn.attr('disabled', 'disabled');
    }

    // Move the map towards the position of the mouse
    var pos = mapDraggable.position();
    if (change > 0) {
        // Zoom In, move the map to the top and left as an amount based on the mouse position
        // new_map_x = map_x - (cursor_x / screen_max_width * (new_map_width - map_width))
        mapDraggable.css('left', pos.left - mapMouseX / mapElement.width() * 100).css('top', pos.top - mapMouseY / mapElement.height() * 100)
        //.css('top', pos.top - (mapMouseY * 0.1))
        ;
    } else if (change < 0) {
        mapDraggable.css('left', pos.left + mapMouseX / mapElement.width() * 100).css('top', pos.top + mapMouseY / mapElement.height() * 100)
        //.css('top', pos.top + (mapMouseY * 0.1))
        ;
    }
}

/**
 * Add update click on all points
 */
function initPointClick() {
    $.each($('.point'), function (index) {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function (e) {
            // Need this first, so that if we are still moving, it doesn't move to location
            e.preventDefault();

            if (mapPointIsMoving === true) {
                return;
            }
            loadMapPoint($(this));
        });
    });
}

/**
 * Toggle showing or hiding of points on the map
 * @param show
 */
function mapTogglePoints(show) {
    if (show) {
        mapToggleHide.show();
        mapToggleShow.hide();

        $.each($('.map .point'), function () {
            $(this).show();
        });
    } else {
        mapToggleHide.hide();
        mapToggleShow.show();

        $.each($('.map .point'), function () {
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

    // First things first, resize the map area to show the panel on the first click.
    if (mapEventFirstClick) {
        mapHelper.fadeOut();
        mapEventFirstClick = false;
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

    // Want to load the side panel with the content.
    if (mapPanel.hasClass('hidden')) {
        mapPanel.removeClass('hidden');
        $('#location-map-main').removeClass('col-md-12').addClass('col-md-9 col-sm-8');
    }

    mapPanelLoader.show();
    mapPanelTarget.html('');

    $.ajax(element.data('url')).done(function (data) {
        mapPanelLoader.hide();
        mapPanelTarget.html(data);

        // Closing the modal
        $('.entity-close').on('click', function (e) {
            console.log('clicky');
            mapPanel.addClass('hidden');
            $('#location-map-main').removeClass('col-md-9 col-sm-8').addClass('col-md-12');
        });
    });
}

/**
 * Switch between Admin and View Mode
 */
function initMapModeSwitch() {
    mapAdminMode.click(function (e) {
        $(this).hide();
        mapAdminModeActivated = true;
        mapViewMode.show();
        mapElement.addClass('map-admin-mode');

        activateMovePoints();
    });

    mapViewMode.click(function (e) {
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
    mapImage.click(function (e) {
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
        magnifier = mapZoomValue / 100;
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
    $.each($('.point'), function (index) {
        addPointMove($(this));
    });
}

/**
 * Enable dragging map points
 */
function activateMovePoints() {
    $.each($('.point'), function (index) {
        $(this).draggable({ disabled: false });
    });
}

/**
 * Disable draggin map points
 */
function disableMovePoints() {
    $.each($('.point'), function (index) {
        $(this).draggable({ disabled: true });
    });
}

/**
 * Add movable points
 * @param point
 */
function addPointMove(point) {
    point.draggable({
        revert: false,
        start: function start(event, ui) {
            //console.log('start moving point');
            mapPointIsMoving = true;

            target = $(event.target);
            target.addClass('point-moving');
        },
        stop: function stop(event, ui) {
            // event.preventDefault();
            var location = $(event.target);
            location.removeClass('point-moving');

            mapPositionX = ui.position.left;
            mapPositionY = ui.position.top;

            // Recalculate position based on zoom
            magnifier = mapZoomValue / 100;
            mapPositionX = mapPositionX / magnifier;
            mapPositionY = mapPositionY / magnifier;

            $.ajax({
                url: location.attr('data-url-move') + '?axis_x=' + mapPositionX + '&axis_y=' + mapPositionY
            }).done(function (result, textStatus, xhr) {
                //event.preventDefault();
            }).fail(function (result, textStatus, xhr) {
                // console.log('map point error', result);
            });

            // We can wait for the ajax request to finish, as the user doesn't need to know that
            // the event was done properly. This also allows directly clicking on a point
            // after it was moved to view the form modal
            setTimeout(function () {
                mapPointIsMoving = false;
            }, 50);

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
    initIconSelect();

    $('.map-point-form').submit(function (e) {
        var formData = $(this).serialize();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json',
            encode: true
        }).done(function (data) {
            mapModal.modal('hide');
            if (data.point) {
                // Remove existing one?
                var existing = $('#' + data.id);
                if (existing.length === 1) {
                    existing.remove();
                }

                $('.map-container').append(data.point);
                initPointClick();

                // Make the new point movable and add tooltip
                newPoint = $('#' + data.id);
                addPointMove(newPoint);

                magnifier = mapZoomValue / 100;
                repositionPoint(newPoint, magnifier);

                newPoint.tooltip();
            }
        }).fail(function (data) {
            console.log('fail', data);
            if (data.responseJSON.errors) {
                $('.location-map-errors').html(buildErrors(data.responseJSON.errors)).fadeIn();
            }
        });

        e.preventDefault();
    });
}

/**
 *
 */
function initDeleteMapPoint() {
    $('.map-point-delete').each(function () {
        $(this).click(function (e) {
            url = $(this).data('url');
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
    $(window).bind('wheel', function (event) {
        if (event.ctrlKey == true) {
            event.preventDefault();
            //console.log('wheel', event.originalEvent.deltaY);
            if (event.originalEvent.deltaY > 0) {
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
    point.css('top', point.data('top') * magnifier + 'px');
    point.css('left', point.data('left') * magnifier + 'px');
    point.css('width', point.data('size') * magnifier + 'px');
    point.css('height', point.data('size') * magnifier + 'px');
    //$(this).css('border-radius', (25 * magnifier)+ 'px');

    fontSize = 24;
    if (point.data('size') === 25) {
        fontSize = 12;
    } else if (point.data('size') === 100) {
        fontSize = 56;
    }
    point.css('font-size', fontSize * magnifier + 'px');
}

/**
 * Resize the map to the map div on page load
 */
function resizeMapToPage() {
    // Reset the zoom to the biggest value
    var imgWidth = mapImage.width();

    $('.loading-map').hide();

    var imgHeight = mapImage.height();
    //console.log('img width, height', imgWidth, imgHeight);

    // Get the view box width and height
    var mapWidth = mapElement.width();
    var mapHeight = mapElement.height();
    //console.log('div width, height', mapWidth, mapHeight);

    // Resize zoom. Always use the width.
    var ratio = mapWidth / imgWidth;

    mapZoomValue = Math.floor(100 * ratio);
    mapZoom(0);
}

/**
 *
 * @param state
 * @returns {*}
 */
function formatState(state) {
    // Searching...
    if (!state.id) {
        return state.text;
    }

    var element = $(state.element);
    if (!element) {
        return state.text;
    }
    var icon = element.data('icon');
    // If there is no icon, use the id
    if (!icon) {
        icon = 'ra ra-' + state.id;
    } else if (icon === 'entity') {
        return state.text;
    }
    // If the icon has no space, it's probably not rpg-awesome
    else if (!icon.includes(' ')) {
            icon = 'ra ra-' + icon;
        }

    var $state = $('<span><i class="' + icon + '"></i> ' + state.text + '</span>');
    return $state;
};

/**
 *
 */
function initIconSelect() {
    $(".select2-icon").select2({
        templateResult: formatState,
        templateSelection: formatState,
        language: $(this).data('language')
    });
}

/***/ }),

/***/ 3:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/location/map.js");


/***/ })

/******/ });