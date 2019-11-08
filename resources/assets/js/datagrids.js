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
        setDatagridAction('permissions', '#datagrid-bulk-permission-models');
    });
    $('#datagrids-bulk-actions-batch').on('click', function() {
        setDatagridAction('batch', '#datagrid-bulk-batch-models');
    });
}

/**
 * Set the datagrid action
 * @param action
 */
function setDatagridAction(action, modelField) {
    var values = [];
    $.each($("input[name='model[]']"), function () {
        if ($(this).prop('checked')) {
            values.push($(this).val());
        }
    });

    $(modelField).val(values.toString());
    console.log('models', values);
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
        $('.datagrid-bulk-actions').hide();
    } else {
        $('.datagrid-bulk-actions').show();
    }
}