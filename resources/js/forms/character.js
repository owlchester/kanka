var characterAddOrganisation, characterTemplateOrganisation, characterOrganisations;


$(document).ready(function () {

    characterOrganisations = $('.character-organisations');

    characterAddOrganisation = $('#add_organisation');
    if (characterAddOrganisation.length === 1) {
        initCharacterOrganisation();
    }
});

/**
 *
 */
function initCharacterOrganisation() {
    characterTemplateOrganisation = $('#template_organisation');
    characterAddOrganisation.on('click', function (e) {
        e.preventDefault();

        $(characterOrganisations).append('<div class="form-group">' +
            characterTemplateOrganisation.html() +
            '</div>');

        // Replace the temp class with the real class. We need this to avoid having two select2 fields
        characterOrganisations.find('.tmp-org').removeClass('tmp-org').addClass('select2');

        // Handle deleting already loaded blocks
        characterDeleteRowHandler();

        return false;
    });

    characterDeleteRowHandler();
}

/**
 *
 */
function characterDeleteRowHandler() {

    $.each($('.member-delete'), function () {
        $(this).unbind('click').unbind('keydown');
        $(this).on('click', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        }).on('keydown', function (e) {
            // Support for pressing enter on a span
            if (e.key !== 'Enter') {
                return;
            }
            $(this).click();
        });;
    });

    // Always re-calc the sortable traits
    window.initSortable();
    window.initForeignSelect();
}

