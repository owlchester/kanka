// Live search is based on corejs-typeahead.
// Doc: https://github.com/corejavascript/typeahead.js
require('corejs-typeahead');
window.Bloodhound = require('bloodhound-js');

var liveSearchField, liveSearchResults, liveSearchRunning = false;
var liveSearchForm, liveSearchClose;
var searchEngine;


$(document).ready(function() {
    liveSearchField = $('.typeahead');
    if (liveSearchField.length === 1) {
        initLiveSearch();
    }
});

/**
 * Live Search
 */
function initLiveSearch() {
    // Set the Options for "Bloodhound" suggestion engine
    searchEngine = new Bloodhound({
        remote: {
            url: liveSearchField.data('url') + '?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    liveSearchField.typeahead({
        minLength: 3
    },{
        source: searchEngine.ttAdapter(),

        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        name: 'entityList',

        // Data field used for selection injection in the search field
        displayKey: 'name',
        valueKey: 'id',

        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown">'
                + '<div class="list-group-item">' + liveSearchField.data('empty') + '</div>'
                + '</div>'
            ],
            header: [
                ''
            ],
            suggestion: function (data) {
                return '<a href="' + data.url + '" class="list-group-item" title="' + data.tooltip
                    + '" data-toggle="tooltip">'
                    + data.image + data.name + ' (' + data.type + ')</a>'
            }
        }
    })

    //Catch typeahead events
    .on('typeahead:select', submitSuggestion)
    .on('typeahead:autocomplete', submitSuggestion);

    // Mobile search
    liveSearchForm = $('.live-search-form');
    liveSearchClose = $('.live-search-close');
    $('.mobile-search').on('click', function(e) {
        e.preventDefault();
        liveSearchForm.removeClass('visible-md').removeClass('visible-lg');
        $('.navbar-custom-menu').hide();
    });

    liveSearchClose.on('click', function(e) {
        e.preventDefault();
        liveSearchForm.addClass('visible-md').addClass('visible-lg');
        $('.navbar-custom-menu').show();

    })
}
/*
 * User triggered a submit, either via the typeahead:submit
 * or autocomplete event
 */
function submitSuggestion(ev, suggestion) {
    //liveSearchField.val(suggestion.name);
    liveSearchField.prop('disabled', true);
    window.location = suggestion.url;
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