// id="datagrids-bulk-actions-permissions"
// id="datagrids-bulk-actions-edit


$(document).ready(function () {
    // Multi-delete
    var crudDelete = $('#datagrid-select-all');
    if (crudDelete.length > 0) {
        crudDelete.click(function (e) {
            if ($(this).prop('checked')) {
                $.each($("input[name='model[]']"), function () {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($("input[name='model[]']"), function () {
                    $(this).prop('checked', false);
                });
            }
            toggleCrudMultiDelete();
        });
    }
    $.each($("input[name='model[]']"), function () {
        $(this).change(function (e) {
            toggleCrudMultiDelete();
            e.preventDefault();
        });
    });

    registerBulkActions();
    toggleCrudMultiDelete();
});

/**
 * Register button handeling for bulk actions
 */
function registerBulkActions() {
    $('#datagrids-bulk-actions-permissions').on('click', function() {
        setBulkModels('#datagrid-bulk-permission-models');
    });
    $('#datagrids-bulk-actions-batch').on('click', function() {
        setBulkModels('#datagrid-bulk-batch-models');
    });
    $('#datagrids-bulk-actions-delete').on('click', function() {
        setBulkModels('#datagrid-bulk-delete-models');
    });
    $('#datagrids-bulk-actions-copy-campaign').on('click', function() {
        console.log('aaa');
        setBulkModels('#datagrid-bulk-permission-models');
    });
}

/**
 * Set the datagrid bulk models
 * @param modelField
 */
function setBulkModels(modelField) {
    var values = [];
    $.each($("input[name='model[]']"), function () {
        if ($(this).prop('checked')) {
            values.push($(this).val());
        }
    });

    console.log('datagrid models', values);

    $(modelField).val(values.toString());
}


/**
 *
 */
function toggleCrudMultiDelete()
{
    var hide = true;

    $.each($("input[name='model[]']"), function () {
        if ($(this).prop('checked')) {
            hide = false;
        }
    });

    if (hide) {
        $('.datagrid-bulk-actions .btn').prop('disabled', true).addClass('disabled');
    } else {
        $('.datagrid-bulk-actions .btn').prop('disabled', false).removeClass('disabled');
    }
}
