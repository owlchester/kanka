/**
 * Crud
 */
var entityNoteModal, entityNoteModalTitle, entityNoteModalBody;

// Character
var characterAddPersonality, characterTemplatePersonality;
var characterAddAppearance, characterTemplateAppearance;
var characterSortPersonality, characterSortAppearance;
var entityFormActions, entityFormDefaultAction;

var filtersActionsShow, filtersActionHide;

var ajaxModalTarget;

$(document).ready(function() {
    // Filters
    var filters = $('#crud-filters');
    if (filters.length === 1) {
        initCrudFilters();
    }

    // Multi-delete
    var crudDelete = $('#datagrid-select-all');
    if (crudDelete.length > 0) {
        crudDelete.click(function (e) {
            if ($(this).prop('checked')) {
                $.each($("input[name='model[]']"), function (index) {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($("input[name='model[]']"), function (index) {
                    $(this).prop('checked', false);
                });
            }
            toggleCrudMultiDelete();
        });
    }
    $.each($("input[name='model[]']"), function (index) {
        $(this).change(function (e) {
            toggleCrudMultiDelete();
        });
    });

    // Notes modal
    entityNoteModal = $('#entity-note');
    entityNoteModalTitle = $('#entity-note-title');
    entityNoteModalBody = $('#entity-note-body');
    $.each($('[data-toggle="entity-note"]'), function () {
        $(this).click(function (e) {
            e.preventDefault();
           entityNoteModalTitle.html($(this).attr('data-title'));
           entityNoteModalBody.html($(this).attr('data-entry'));
           entityNoteModal.modal();

           // Add tooltips in modal!
           $('[data-toggle="tooltip"]').tooltip();
        });
    });

    characterSortPersonality = $('.character-personality');
    characterSortAppearance = $('.character-appearance');

    characterAddPersonality = $('#add_personality');
    if (characterAddPersonality.length === 1) {
        initCharacterPersonality();
    }
    characterAddAppearance = $('#add_appearance');
    if (characterAddAppearance.length === 1) {
        initCharacterAppearance();
    }

    $.each($('[data-toggle="ajax-modal"]'), function () {
        $(this).click(function (e) {
            e.preventDefault();
            ajaxModalTarget = $(this).attr('data-target');
            $.ajax({
                url: $(this).attr('data-url')
            }).done(function (result, textStatus, xhr) {
                if (result) {
                    $(ajaxModalTarget).find('.modal-content').html(result);
                    $(ajaxModalTarget).modal();

                    // Reset select2
                    initSelect2();
                }
            }).fail(function (result, textStatus, xhr) {
                //console.log('modal ajax error', result);
            });
            return false;
        });
    });

    entityFormActions = $('.form-submit-actions');
    if (entityFormActions.length > 0) {
        registerEntityFormActions();
    }
});


/**
 *
 */
function toggleCrudMultiDelete() {
    var hide = true;

    $.each($("input[name='model[]']"), function(index) {
        if ($(this).prop('checked')) {
            hide = false;
        }
    });

    if (hide) {
        $('.btn-crud-multi').hide();
    } else {
        $('.btn-crud-multi').show();
    }
}

/**
 * Filters
 */
var previousFilterInputValue = '';
function initCrudFilters() {

    $('#crud-filters .element').on('click', function(e) {
        $(this).children('.value').hide();
        $(this).children('.input').show();

        // Show the field and focus at the end of it
        var input = $(this).children('.input').children('.input-field');
        input.focus();
        var tmp = input.val();
        input.val('');
        input.val(tmp);
        previousFilterInputValue = input.is(':checkbox') ? (input.prop('checked') ? 0 : 1) : tmp;
        //console.log('previous filter', input, previousFilterInputValue);
    });

    $('#crud-filters .element input').on('focusout', function(e) {
        // Only submit on change
        e.preventDefault();
        filterSubmit($(this), false);
    });

    $('#crud-filters select.select2').on('change', function(e) {
        $('#crud-filters-form').submit();
    });

    $('#crud-filters select.filter-select').on('change', function(e) {
        $('#crud-filters-form').submit();
    });

    // Reset button
    $('#crud-filters #filter-reset').on('click', function(e) {
        // Redirect to page without params
        window.location = window.location.href.split("?")[0] + '?reset-filter=true';
    });

    // Show on small displays
    filtersActionShow = $('#crud-filters #filters-show-action');
    filtersActionHide = $('#crud-filters #filters-hide-action');
    filtersActionShow.on('click', function(e) {
        $('#crud-filters #available-filters').removeClass('hidden-xs').removeClass('hidden-sm');
        $('#crud-filters #filter-reset').removeClass('hidden-xs').removeClass('hidden-sm');
        filtersActionShow.hide();
        filtersActionHide.show();
    });

    filtersActionHide.on('click', function(e) {
        $('#crud-filters #available-filters').addClass('hidden-xs').addClass('hidden-sm');
        $('#crud-filters #filter-reset').addClass('hidden-xs').addClass('hidden-sm');
        filtersActionHide.hide();
        filtersActionShow.show();
    });

    $('#crud-filters .input-field').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            filterSubmit($(this), true);
        }
    });
}

/**
 *
 * @param field
 * @param force
 */
function filterSubmit(field, force) {
    var element = field.parent().parent();
    var input = element.children('.input');
    input.hide();
    if (field.is(':checkbox')) {
        if (field.prop('checked')) {
            element.children('.value').html('<i class="fa fa-check"></i>');
        } else {
            element.children('.value').html('');
        }
    } else {
        element.children('.value').html(field.val());
    }
    element.children('.value').show();

    var compare = field.is(':checkbox') ? (field.prop('checked') ? 1 : 0) : field.val();
    //console.log('compare', field, compare, previousFilterInputValue);

    if (force || compare !== previousFilterInputValue) {
        $('#crud-filters-form').submit();
    }
}

/**
 *
 */
function initCharacterPersonality()
{
    characterTemplatePersonality = $('#template_personality');
    characterAddPersonality.on('click', function(e) {
        e.preventDefault();

        $(characterSortPersonality).append('<div class="form-group">' +
            characterTemplatePersonality.html() +
            '</div>');

        // Handle deleting already loaded blocks
        characterDeleteRowHandler();

        return false;
    });

    characterDeleteRowHandler();
}

/**
 *
 */
function initCharacterAppearance()
{
    characterTemplateAppearance = $('#template_appearance');
    characterAddAppearance.on('click', function(e) {
        e.preventDefault();

        $(characterSortAppearance).append('<div class="form-group">' +
            characterTemplateAppearance.html() +
            '</div>');

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
    $.each($('.personality-delete'), function (index) {
        $(this).unbind('click'); // remove previous bindings
        $(this).on('click', function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().remove();
        });
    });

    // Always re-calc the sortable traits
    characterSortPersonality.sortable();
    characterSortAppearance.sortable();
}

/**
 * This is re-defined (copy-paste) from app.js, since the minify changes the original name
 */
function initSelect2() {
    if ($('.select2').length > 0) {
        $.each($('.select2'), function (index) {

            $(this).select2({
//            data: newOptions,
                placeholder: $(this).attr('data-placeholder'),
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    quietMillis: 200,
                    url: $(this).attr('data-url'),
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    }
}

/**
 *
 */
function registerEntityFormActions() {
    entityFormDefaultAction = $('#form-submit-main');
    $.each(entityFormActions, function(ele) {
        $(this).on('click', function(e) {
            console.log('clicked on', $(this).data('action'));
            entityFormDefaultAction.html($(this).html()).attr('name', $(this).data('action')).click();
            return false;
        });
    })
}