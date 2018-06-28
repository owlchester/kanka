$(document).ready(function() {
    if($('#add_attribute_target').length > 0) {
        initAttributeUI();
    }
});

/**
 * Initiate on click handles for attribute interface
 */
function initAttributeUI()
{
    var target = $('#add_attribute_target');
    var addBtn = $('#attribute_add');
    var template = $('#attribute_template');

    initAttributeDelete();
    addBtn.on('click', function(e) {
        template.clone().insertBefore(target);
        initAttributeDelete();

        return false;
    });

}

/**
 * This function rebinds the delete on all buttons
 */
function initAttributeDelete() {

    $('.entity-attributes').sortable();

    $.each($('.attribute_delete'), function() {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function() {
            $(this).parent().parent().parent().remove();
        });
    });
}