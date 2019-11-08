// id="datagrids-bulk-actions-permissions"
// id="datagrids-bulk-actions-edit


$(document).ready(function () {

    $('#datagrids-bulk-actions-permissions').on('click', function() {
        setDatagridAction('permissions');
    });
    $('#datagrids-bulk-actions-batch').on('click', function() {
        setDatagridAction('batch');
    });
    $('#datagrids-bulk-actions-delete').on('click', function() {
        setDatagridAction('delete');
    });
    $('#datagrids-bulk-actions-export').on('click', function() {
        setDatagridAction('export');
    });
});

/**
 * Set the datagrid action
 * @param action
 */
function setDatagridAction(action) {
    $('#datagrid-bulk-action').val(action);
}