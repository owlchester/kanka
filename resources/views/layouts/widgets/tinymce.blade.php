@section('scripts')
    <script>
        var editor_config = {
            path_absolute : "/",
            language: '{{ App::getLocale() == 'en-US' ? 'en' : App::getLocale() }}',
            selector: "textarea.html-editor",
            plugins: [
                "save autosave advlist autolink lists link image hr anchor pagebreak",
                "searchreplace code fullscreen",
                "insertdatetime media nonbreaking table directionality",
                "emoticons paste textcolor colorpicker textpattern",
                "fullpage mention media"
            ],
            toolbar: "styleselect | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table media",
            // mobile: {
            //     theme: 'mobile',
            //     plugins: [ 'save', 'lists', 'autolink', 'mention']
            // },
            nanospell_server:"php",
            browser_spellcheck: true,
            relative_urls: false,
            remove_script_host: false,
            branding: false,
            media_live_embeds: true,
            menubar: false,
            themes: "modern",
            mentions: {
                delimiter: ['@', '#'],
                source: function(query, process, delimiter) {
                    console.log('yo');
                    if (delimiter === '@') {
                        $.getJSON('{{ route('search.mentions') }}?q='+ query, function(data) {
                            process(data)
                        })
                    }
                    if (delimiter === '#') {
                        $.getJSON('{{ route('search.months') }}?q='+ query, function(data) {
                            process(data)
                        })
                    }
                },
                insert: function(item) {
                    if (item.url) {
                        if (item.tooltip) {
                            var str = '<a href="' + item.url + '" title="' + item.tooltip.replace(/["]/g, '\'') + '" data-toggle="tooltip" data-html="true" >' + item.fullname + '</a>';
                            return str;
                        }
                        return '<a href="' + item.url + '">' + item.fullname + '</a>';
                    }
                    return item.fullname;
                },
                render: function(item) {
                    return '<li>' +
                        '<a href="javascript:;"><span>' + (item.image ? item.image : '') + item.fullname + (item.type ? ' (' + item.type + ')' : '') + '</span></a>' +
                        '</li>';
                }
            },
            save_onsavecallback: function () {
                // Set the global dirty check off
                window.entityFormHasUnsavedChanges = false;
                tinymce.activeEditor.setDirty(false);
                $("form[data-shortcut='1']").submit();
            }
        };

        tinymce.init(editor_config);
    </script>
@endsection

@section('styles')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
@endsection