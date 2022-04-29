// id="datagrids-bulk-actions-permissions"
// id="datagrids-bulk-actions-edit

import ajaxModal from "./components/ajax-modal";

var datagrid2DeleteConfirm = false;
var datagrid2Form;
var datagrid2Table;

var datagrid2Observer = new IntersectionObserver(function(entries) {
    // isIntersecting is true when element and viewport are overlapping
    // isIntersecting is false when element and viewport don't overlap
    if(entries[0].isIntersecting === true) {
        //console.log('Element has just become visible in screen', entries[0]);
        datagrid2Reorder($('.datagrid-onload'));
    }

}, { threshold: [0] });


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
    registerDatagrids2();
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
        setBulkModels('#datagrid-bulk-permission-models');
    });
    $('#datagrids-bulk-actions-templates').on('click', function() {
        setBulkModels('#datagrid-bulk-permission-models');
    });
    $('#datagrids-bulk-actions-transform').on('click', function() {
        setBulkModels('#datagrid-bulk-transform-models');
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

function registerDatagrids2()
{
    $('.datagrid-submit').click(function (e) {
        e.preventDefault();

        datagrid2Form = $(this).closest('form');
        //console.log('form', form);

        let action = datagrid2Form.find('input[name="action"]');
        action.val($(this).data('action'));

        //console.log('action', action);
        //console.log('me', $(this).data('action'));

        if ($(this).data('action') === 'delete') {
            if (datagrid2DeleteConfirm === false) {
                $('#datagrid-bulk-delete').modal();
                return false;
            }
        }

        // Disable the whole dropdown and replace it with a spinning wheel
        $('.datagrid-bulk-actions').hide();
        $('.datagrid-spinner').show();
        datagrid2Form.submit();
    });

    $('#datagrid-action-confirm').click(function (e) {
        $('#datagrid-bulk-delete').modal('hide');
        datagrid2Form.submit();
    });

    initDatagrid2Ajax();
    initDatagrid2OnLoad();
}

function initDatagrid2Ajax() {
    $.each($('table[data-render="datagrid2"]'), function (i) {
        datagrid2Table = $(this);
        $(this).find('thead a').click(function (e) {
            e.preventDefault();
            datagrid2Reorder($(this));
        });
        $(this).closest('#datagrid-parent').find('.pagination > li > a').click(function (e) {
            e.preventDefault();
            datagrid2Reorder($(this));
        });
    });
}

function initDatagrid2OnLoad() {
    if ($('.datagrid-onload').length == 0) {
        return;
    }
    datagrid2Observer.observe(document.querySelector('.datagrid-onload'));
}

function datagrid2Reorder(ele) {
    datagrid2Table.find('thead').hide();
    datagrid2Table.find('tbody').hide();
    datagrid2Table.find('tfoot').fadeIn();

    let url = ele.attr('href');
    let dataUrl = ele.data('url');
    if (url === '#' && dataUrl) {
        url = dataUrl;
    }

    let target = ele.data('target') ?? '#datagrid-parent';
    $.ajax(
        url
    ).done(function (res) {
        //console.log('res', res);
        if (res.html) {
            $(target).html(res.html);
        }
        if (res.delete) {
            $('#datagrid-delete-forms').html(res.deletes);
        }
        if (res.url) {
            window.history.pushState({}, "", res.url);
        }
        initDatagrid2Ajax();
        $(document).trigger('shown.bs.modal'); // Get tooltips to re-generate
        // Needed for ajax buttons in campaigns/plugins
        ajaxModal();
    }).fail(function (err) {
        console.error('datagrid2', err);
        datagrid2Table.find('tfoot').addClass('bg-danger');
    });
}
