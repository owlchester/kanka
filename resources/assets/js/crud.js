/**
 * Crud
 */

// Character
var characterAddPersonality, characterTemplatePersonality;
var characterAddAppearance, characterTemplateAppearance;
var characterSortPersonality, characterSortAppearance;
var entityFormActions, entityFormDefaultAction;

var filtersActionsShow, filtersActionHide;

var ajaxModalTarget;
var entityFormHasUnsavedChanges = false;

// Entity Calendar
var entityCalendarAdd, entityCalendarForm, entityCalendarField, entityCalendarMonthField;
var entityCalendarCancel, entityCalendarLoading;

var toggablePanels;

$(document).ready(function() {
    // Filters
    var filters = $('#crud-filters');
    if (filters.length === 1) {
        //initCrudFilters();
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
        registerUnsavedChanges();
    }

    registerFormSubmitAnimation();
    registerEntityCalendarForm();
    registerToggablePanels();
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
    $('#crud-filters #filters-reset').on('click', function(e) {
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
            $(this).closest('.parent-delete-row').remove();
        });
    });

    // Always re-calc the sortable traits
    characterSortPersonality.sortable();
    characterSortAppearance.sortable();
}

/**
 *
 */
function registerEntityFormActions() {
    entityFormDefaultAction = $('#form-submit-main');
    // Register click on each sub action
    $.each(entityFormActions, function(ele) {
        $(this).on('click', function(e) {
            entityFormDefaultAction
                .attr('name', $(this).data('action'))
                .click();
                // .prop('disabled', true);

            return false;
        });
    });
}

/**
 * On all forms, we want to animate the submit button when it's clicked.
 */
function registerFormSubmitAnimation() {
    $.each($('form'), function(ele) {
        $(this).on('submit', function(e) {
            // Saving, skip alert.
            window.entityFormHasUnsavedChanges = false;

            // Find the main button
            submit = $(this).find('.btn-success');
            if (submit.length > 0) {
                $.each(submit, function(su) {
                    if ($(this).hasClass('dropdown-toggle')) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this)
                            .html('<i class="fa fa-spinner fa-spin"></i>')
                            .prop('disabled', true);
                    }
                });

                // Inject the selected option for the "workflow" (submit-action)
                $(this).append('<input type="hidden" name="' + $('#form-submit-main').attr('name') + '" />');
            }

            return true;
        })
    });
}

function registerEntityCalendarForm() {
    entityCalendarAdd = $('#entity-calendar-form-add');
    if (entityCalendarAdd.length === 1) {
        entityCalendarCancel = $('#entity-calendar-form-cancel');
        entityCalendarForm = $('.entity-calendar-form');
        entityCalendarSubForm = $('.entity-calendar-subform');
        entityCalendarField = $('#calendar_id');
        entityCalendarMonthField = $('select[name="calendar_month"]');
        entityCalendarLoading = $('.entity-calendar-loading');

        entityCalendarAdd.on('click', function(e) {
            e.preventDefault();

            entityCalendarAdd.hide();
            entityCalendarForm.show();

            var defaultCalendarId = entityCalendarAdd.data('default-calendar');
            if (defaultCalendarId) {
                entityCalendarField.val(defaultCalendarId);
                entityCalendarCancel.show();
                entityCalendarSubForm.fadeIn();
                loadCalendarDates(defaultCalendarId);
            }
            return false;
        });

        entityCalendarField.on('change', function(e) {
            entityCalendarSubForm.hide();
            // No new calendar selected? hide everything again
            if (!entityCalendarField.val()) {
                calendarHideSubform();
                return;
            }
            entityCalendarLoading.show();
            // Load month list
            loadCalendarDates(entityCalendarField.val());
        });

        entityCalendarCancel.on('click', function(e) {
            e.preventDefault();
            entityCalendarField.val(null);
            entityCalendarCancel.hide();
            calendarHideSubform();
        });
    }
}

function loadCalendarDates(calendarID) {
    calendarID = parseInt(calendarID);
    var url = entityCalendarAdd.data('url').replace('/0/', '/' + calendarID + '/');
    $.ajax(url)
        .done(function(data) {
                entityCalendarMonthField.html('');
                var id = 1;
                $.each(data, function() {
                    entityCalendarMonthField.append('<option value="' + id + '">' + this.name + '</option>');
                    id++;
                });
                entityCalendarLoading.hide();
                entityCalendarSubForm.show();

                // However, if there is only one result, select id.
                if (data.length === 1) {
                    entityCalendarMonthField.val(data[0].id);
                }
            }
        );
}

/**
 *
 */
function calendarHideSubform() {
    entityCalendarForm.hide();
    entityCalendarAdd.show();
    $('input[name="calendar_day"]').val(null);
    $('input[name="calendar_month"]').val(null);
    $('input[name="calendar_year"]').val(null);
}

/**
 * Some panels can have their body toggled
 */
function registerToggablePanels() {
    toggablePanels = $('.panel-toggable');
    $.each(toggablePanels, function (i) {
        $(this).on('click', function(e) {
            $(this).parent().children('.panel-body').fadeToggle();
            var i = $(this).find('i.fa');
            if (i.hasClass('fa-caret-down')) {
                i.removeClass('fa-caret-down').addClass('fa-caret-left');
            } else {
                i.removeClass('fa-caret-left').addClass('fa-caret-down');
            }
        });

    });
}

/**
 * If we change something on a form, avoid losing data when going away.
 */
function registerUnsavedChanges() {
    var save = $('#form-submit-main');

    // Save every input change
    $(document).on('change', ':input', function(){
        window.entityFormHasUnsavedChanges = true;
    });

    if (save.length === 1) {
        // Another way to bind the event
        $(window).bind('beforeunload', function (e) {
            if (window.entityFormHasUnsavedChanges) {
                var message = save.data('unsaved');
                e.returnValue = message;
                return message;
            }
        });
    }
}