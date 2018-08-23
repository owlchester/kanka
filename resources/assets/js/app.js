
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });
var liveSearchField, liveSearchResults, liveSearchRunning = false;

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

    initSelect2();

    if ($('.date-picker').length > 0) {
        $.each($('.date-picker'), function (index) {
            // instance, using default configuration.
            $(this).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });
        });
    }

    $.each($('.img-delete'), function (index) {
        $(this).click(function (e) {
            $('input[name=' + $(this).attr('data-target') + ']')[0].value = 1;
            $('.preview').hide();
        });
    });


    if ($('#delete-confirm-form').length > 0) {
        $('#delete-confirm-form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    }

    $.each($('.new-entity-selector'), function (index) {
        $(this).on('click', function (e) {
            $('#new-entity-type').val($(this).attr('data-entity'));
            $('#new-entity-form').attr('data-parent', $(this).attr('data-parent'));
        });
    });

    if ($('#new-entity-form').length > 0) {
        $('#new-entity-form').on('submit', function (e) {
            $('#new-entity-errors').hide();
            var target = $(this).attr('data-parent');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize()
            }).done(function (result, textStatus, xhr) {
                if (textStatus === 'success' && result.id) {
                    $('#' + target).append(new Option(result.name, result.id)).val(result.id).trigger('change');

                    // Close modal
                    $('#new-entity-modal').modal('toggle');
                    $('#new-entity-errors').hide();
                    $('#new-entity-name').val('');
                } else {
                    $('#new-entity-errors').show();
                }
            }).fail(function (result, textStatus, xhr) {
                $('#new-entity-errors').show();
            });

            e.preventDefault();
            return false;
        });
    }


    // Treeview for locations
    var treeViewLoader = $('#locations-treeview');
    if (treeViewLoader.length > 0) {
        treeViewInit('locations');
    }

    // Treeview for sections
    var sectionViewLoader = $('#sections-treeview');
    if (sectionViewLoader.length > 0) {
        treeViewInit('sections');
    }

    manageTabs();
    manageDashboardNotifications();


    // Live search on forms
    /*$.each($('.datagrid-search'), function(index) {
        $(this).submit(function(event) {
            event.preventDefault();

            window.location.href =
        });
    });*/

    // Delete confirm dialog
    $.each($('.delete-confirm'), function (index) {
        $(this).click(function (e) {
            var name = $(this).attr('data-name');
            var text = $(this).attr('data-text');
            if (text) {
                $('#delete-confirm-text').text(text);
            } else {
                $('#delete-confirm-name').text(name);
            }
        });
    });

    // Submit modal form
    $.each($('#delete-confirm-submit'), function (index) {
        $(this).click(function (e) {
            $('#delete-confirm-form').submit();
        })
    });

    // Delete confirm dialog
    $.each($('.click-confirm'), function (index) {
        $(this).click(function (e) {
            var name = $(this).attr('data-message');
            $('#click-confirm-text').text(name);
            $('#click-confirm-url').attr('href', $(this).attr('data-url'));
        });
    });

    initLiveSearch();
});

/**
 *
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
 * Go through table trs to add on click support
 */
function treeViewInit(element) {
    var treeViewLoader = $('#' + element + '-treeview');
    var link = treeViewLoader.attr('data-url');
    $.each($('#' + element + ' > tbody > tr'), function(index) {
        children = $(this).attr('data-children');
        if (parseInt(children) > 0) {
            $(this).addClass('tr-hover');
            $(this).on('click', function (e) {
                window.location = link + '?parent_id=' + $(this).attr('data-id');
            });
        }
    });
}

/**
 * Save and manage tabs for when refreshing
 */
function manageTabs() {
    var tabLink = $('.nav-tabs li a');
    tabLink.click(function(e) {
        e.preventDefault();

        // If tab isn't ajax request
        if (!$(this).data('url')) {
            $(this).tab('show');
        }
    });

    // store the currently selected tab in the hash value
    tabLink.on("shown.bs.tab", function(e) {
        e.preventDefault();
        var tabId = $(e.target).attr("href").substr(1);
        var dataToggle = $(e.target).attr('ajax-modal');

        if (dataToggle && dataToggle == 'ajax-modal') {
            // Modal? Don't do more.
            return true;
        }
        // We fake a tab_ to avoid page jumps from the browser
        window.location.hash = 'tab_' + tabId;
    });

    // on load of the page: switch to the currently selected tab
    var tabHash = window.location.hash.replace('tab_', '');
    $('ul.nav-tabs > li > a[href="' + tabHash + '"]').tab('show');
}

/**
 *
 */
function manageDashboardNotifications() {
    $.each($('.click-notification'), function(index) {
        $(this).modal();
    });

    $.each($('.notification-delete'), function(index) {
        $(this).on('click', function() {
            $.ajax({
                url: $(this).attr('data-url'),
                dataType: 'json'
            });

            // Had this in the done, but it never fired?
            var parent = $(this).attr('data-parent');
            $('#' + parent).modal('toggle');
        });

    });
}

/**
 * Live Search
 */
function initLiveSearch() {
    liveSearchField = $('.typeahead');
    liveSearchResults = $('#live-search-results');
    if (liveSearchField.length == 0) {
        return;
    }

    liveSearchField.keyup(function (e) {
        if (liveSearchField.val().length >= 3) {
            // Delay the request for 250 seconds
            var value = liveSearchField.val();
            setTimeout(function() { requestLiveSearch(value); }, 250);
        } else {
            liveSearchResults.empty();
        }
    });

    liveSearchField.focusout(function (e) {
        console.log('liveSearchResults lost focus');
        setTimeout(function() {
            liveSearchResults.empty();
        }, 250);
    });
}

function requestLiveSearch(value) {
    if (liveSearchField.val() === value && !liveSearchRunning) {
        liveSearchRunning = true;

        // Reset results
        liveSearchResults.empty();
        liveSearchResults.append('<div class="loading"><i class="fa fa-spinner"></i></div>');

        $.ajax({
            url: liveSearchField.attr('data-url') + '?q=' + liveSearchField.val()
        }).done(function (result, textStatus, xhr) {
            liveSearchRunning = false;
            if (textStatus === 'success' && result) {
                liveSearchResults.empty();
                // Append all the results to the result box
                $.each(result, function(i) {
                    var data = result[i];
                    liveSearchResults.append('<a href="' + data.url + '" class="list-group-item">' + data.image + data.name + ' (' + data.type + ')</a>');
                });

                // Empty result
                if (result.length === 0) {
                    liveSearchResults.append('<div class="loading">' + liveSearchField.attr('data-empty') + '</div>');
                }
                liveSearchResults.focus();
            }
        }).fail(function (result, textStatus, xhr) {
            liveSearchRunning = false;
            liveSearchResults.empty();
            liveSearchResults.append('Error!');
            console.log('error', result);
        });
    }
}

// Helpers are injected directly in the window functions.
require('./helpers.js');

require('./attributes.js');
require('./keyboard.js');
require('./map.js');
require('./crud.js');
require('./calendar.js');
require('./conversation.js');