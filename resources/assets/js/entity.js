var entityFileUi, entityFileModal;
var entityFileDrop, entityFileProgress, entityFileMax;
var openingEntityFileModal = false;

$(document).ready(function () {
    registerPrivacyToggle();
});

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

        errors += data[key] + "\n";
    }
    return errors;
}

/**
 * Toggle the privacy of an entity
 */
function registerPrivacyToggle() {
    $('.entity-private-toggle').click(function() {
        $(this).addClass('disabled');

        let child = $(this).children('i.fa');
        child.removeClass().addClass('fa fa-spin fa-spinner');

        $.post({
            url: $(this).data('url'),
            data: {},
            context: this
        }).done(function (res) {
            if (!res.success) {
                return;
            }

            let child = $(this).children('i.fa');
            let cssClass = res.status ? $(child).data('off') : $(child).data('on');
            let title = res.status ? $(child).data('title-off') : $(child).data('title-on');
            child.removeClass().addClass('fa').addClass('fa-' + cssClass).attr('title', title);

            $(this).removeClass('disabled');
        });
    });
}
