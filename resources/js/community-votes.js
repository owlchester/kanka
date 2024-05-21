$(document).ready(function() {
    initCommunityVotes();
});

var ajaxUrl;
var options;
var selected;

function initCommunityVotes() {
    ajaxUrl = $("#community-vote-url");
    if (ajaxUrl.length === 0) {
        return;
    }

    options = $('.vote-body');

    options.click(function () {
        let option = $(this).data('option');
        if ($(this).hasClass('vote-selected')) {
            // Remove vote
            vote();
        } else {
            vote(option);
        }
    });
}

function vote(element) {
    options.each(function() {
        $(this).removeClass('vote-selected');
    });

    let data = {vote: element};
    selected = element;
    $.post(
        ajaxUrl.val(),
        data
    ).done(function (result) {
        if (element) {
            $(".vote-body[data-option='" + selected + "']").addClass('vote-selected');
        }

        if (result.data) {
            updateStats(result.data);
        }
    }).fail(function () {
        // console.log('map point error', result);
    });
}

function updateStats(results) {
    for (const [key, value] of Object.entries(results)) {
        $(".vote-progress[data-width='" + key + "']").width(value + '%');
        $(".vote-result[data-result='" + key + "']").html(value + '%');
    }
}
