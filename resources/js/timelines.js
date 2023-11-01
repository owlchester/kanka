let oldEra, eraAdd;

$(document).ready(function () {
    registerElementForm();
});

/**
 * Dynamically update the element's "position" dropdown field based on the selected era.
 */
function registerElementForm() {
    let field = $('#element-era-id');
    if (field.length === 0) {
        return;
    }
    oldEra = field.val();

    if (field.length === 1) {
        field.on('change', function () {
            // Load era list
            loadTimelineEra(field.val());
        });
    }
}

/**
 *
 * @param eraID
 */
function loadTimelineEra(eraID) {
    eraID = parseInt(eraID);
    let url = $('input[name="era-data-url"]').data('url').replace('/0/', '/' + eraID + '/');
    let oldPosition = $('input[name="oldPosition"]').data('url');

    $.ajax(url)
        .done(function (data) {
            let eraField = $('select[name="position"]');
            eraField.html('');
            let id = 1;
            $.each(data.positions, function (i) {
                let position = data.positions[i];
                let selected = ' selected="selected"';

                if (oldPosition && !i && (oldEra == eraID)) {
                    eraField.append('<option value="" data-length="' + position.length + '" ' + selected + '>' + position + '</option>');
                }
                if (i) {
                    eraField.append('<option value="' + id + '" data-length="' + position.length + '" ' + selected + '>' + position + '</option>');
                }
                id++;
            });
        });
}
