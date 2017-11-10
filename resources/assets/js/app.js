
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

const app = new Vue({
    el: '#app'
});


// add custom js
/*$('.sidebar-toggle').on('click', function() {
    var cls = $('body').hasClass('sidebar-collapse');
    if (cls == true) {
        $('body').removeClass('sidebar-collapse');
    } else {
        $('body').addClass('sidebar-collapse');
    }
});*/

if ($('.select2').length > 0) {
    $.each($('.select2'), function(index) {
       $(this).select2({
            placeholder: $(this).attr('data-palceholder'),
            allowClear: true,
            minimumInputLength: 3,
                ajax: {
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

// Need to wait for ckeditor cdn
$(document).ready(function() {
    if ($('.html-editor').length > 0) {
        $.each($('.html-editor'), function(index) {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace($(this).attr('id'), {
                removePlugins: 'sourcearea',
                removeButtons: 'Source'
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
        console.log(name);
        $('#delete-confirm-name').text(name);
    });
});

// Submit modal form
$.each($('#delete-confirm-submit'), function(index) {
   $(this).click(function(e) {
       $('#delete-confirm-form').submit();
   })
});