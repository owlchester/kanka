
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

var ckEditorCtrl = false;
var ckEditorForm = false;

// Need to wait for ckeditor cdn
$(document).ready(function() {

    if ($('.select2').length > 0) {
        console.log('found select 2s');
        $.each($('.select2'), function(index) {

//        var newOptions = [];
//        $(this).find('option').each(function() {
//            var newOption = new Option(this.text, this.id, true, true);
//            newOptions.push(newOption);
//        });

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

    if ($('.html-editor').length > 0) {
        $.each($('.html-editor'), function(index) {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace($(this).attr('id'), {
                removePlugins: 'sourcearea',
                removeButtons: 'Source'
            });

            // Submit the form on ctrl+s when in the ckeditor field
            var editor = CKEDITOR.instances[$(this).attr('id')];
            ckEditorForm = $(this).parents('form:first');

            editor.on( 'contentDom', function( evt ) {
                editor.document.on( 'keyup', function(event) {
                    if(event.data.$.keyCode == 17) {
                        ckEditorCtrl = false;
                    }
                });

                editor.document.on('keydown', function (event) {
                    if(event.data.$.keyCode == 17) {
                        ckEditorCtrl = true;
                    }
                    if(event.data.$.keyCode == 83 && ckEditorCtrl == true) {
                        try {
                            event.data.$.preventDefault();
                            ckEditorForm.submit();
                        } catch(err) {}

                        return false;
                    }
                });
            });
        });
    }

    if ($('.date-picker').length > 0) {
        $.each($('.date-picker'), function(index) {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            $(this).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });
    }

    $.each($('.img-delete'), function(index) {
        $(this).click(function(e) {
            $('input[name=' + $(this).attr('data-target') + ']')[0].value = 1;
            $('.preview').hide();
        });
    });


    if ($('#delete-confirm-form').length > 0) {
        $('#delete-confirm-form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    }

    $.each($('.new-entity-selector'), function(index) {
        $(this).on('click', function (e) {
            $('#new-entity-type').val($(this).attr('data-entity'));
            $('#new-entity-form').attr('data-parent', $(this).attr('data-parent'));
        });
    });

    if ($('#new-entity-form').length > 0) {
        $('#new-entity-form').on('submit', function(e) {
            $('#new-entity-errors').hide();
            var target = $(this).attr('data-parent');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize()
            }).done(function (result, textStatus, xhr) {
                if (textStatus === 'success' && result.id) {
                    $('#' + target).append(new Option(result.name, result.id));

                    // Close modal
                    $('#new-entity-modal').modal('toggle');
                    $('#new-entity-errors').hide();
                    $('#new-entity-name').val('');
                } else {
                    $('#new-entity-errors').show();
                }
            }).fail(function (result, textStatus, xhr) {
                $('#new-entity-errors').show();
            });

            e.preventDefault();
            return false;
        });
    }


    // Crud multi-delete
    var crudDelete = $('#datagrid-select-all');
    if (crudDelete.length > 0) {
        crudDelete.click(function(e) {
            if ($(this).prop('checked')) {
                $.each($("input[name='model[]']"), function(index) {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($("input[name='model[]']"), function(index) {
                    $(this).prop('checked', false);
                });
            }
            toggleCrudMultiDelete();
        });
    }

    $.each($("input[name='model[]']"), function(index) {
       $(this).change(function(e) {
           toggleCrudMultiDelete();
       });
    });

    // Treeview for locations
    var treeViewLoader = $('#location-treeview');
    if (treeViewLoader.length > 0) {
        treeViewInit();
    }

    manageTabs();
    manageDashboardNotifications();
});
// Live search on forms
/*$.each($('.datagrid-search'), function(index) {
    $(this).submit(function(event) {
        event.preventDefault();

        window.location.href =
    });
});*/

// Delete confirm dialog
$.each($('.delete-confirm'), function(index) {
    $(this).click(function(e) {
        var name = $(this).attr('data-name');
        var text = $(this).attr('data-text');
        if (text) {
            $('#delete-confirm-text').text(text);
        } else {
            $('#delete-confirm-name').text(name);
        }
    });
});

// Submit modal form
$.each($('#delete-confirm-submit'), function(index) {
   $(this).click(function(e) {
       $('#delete-confirm-form').submit();
   })
});

// Delete confirm dialog
$.each($('.click-confirm'), function(index) {
    $(this).click(function(e) {
        var name = $(this).attr('data-message');
        $('#click-confirm-text').text(name);
        $('#click-confirm-url').attr('href', $(this).attr('data-url'));
    });
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

    var btn = $('#crud-multi-delete');
    if (hide) {
        btn.hide();
    } else {
        btn.show();
    }
}

/**
 * Go through table trs to add on click support
 */
function treeViewInit() {
    var treeViewLoader = $('#location-treeview');
    var link = treeViewLoader.attr('data-url');
    $.each($('#locations > tbody > tr'), function(index) {
        children = $(this).attr('data-children');
        if (parseInt(children) > 0) {
            $(this).addClass('tr-hover');
            $(this).on('click', function (e) {
                window.location = link + '?parent_location_id=' + $(this).attr('data-id');
            });
        }
    });
}

/**
 * Save and manage tabs for when refreshing
 */
function manageTabs() {
    var tabLink = $('.nav-tabs li a');
    tabLink.click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    tabLink.on("shown.bs.tab", function(e) {
        e.preventDefault();
        var tabId = $(e.target).attr("href").substr(1);
        // We fake a tab_ to avoid page jumps from the browser
        window.location.hash = 'tab_' + tabId;
    });

    // on load of the page: switch to the currently selected tab
    var tabHash = window.location.hash.replace('tab_', '');
    $('ul.nav-tabs > li > a[href="' + tabHash + '"]').tab('show');
}

/**
 *
 */
function manageDashboardNotifications() {
    $.each($('.click-notification'), function(index) {
        $(this).modal();
    });

    $.each($('.notification-delete'), function(index) {
        $(this).on('click', function() {
            $.ajax({
                url: $(this).attr('data-url'),
                dataType: 'json'
            });

            // Had this in the done, but it never fired?
            var parent = $(this).attr('data-parent');
            $('#' + parent).modal('toggle');
        });

    });
}

require('./attributes.js');
require('./keyboard.js');
require('./map.js');