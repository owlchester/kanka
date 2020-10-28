@section('scripts')
    @parent
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        var advancedRequest = false;
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
            toolbar: "undo redo | styleselect | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | hr | link image table media | code fullscreen",
            nanospell_server: "php",
            browser_spellcheck: true,
            relative_urls: false,
            remove_script_host: false,
            branding: false,
            media_live_embeds: true,
            menubar: false,
            content_css: '{{ mix('css/tinymce.css') }}',
            extended_valid_elements: "+@[data-mention]",
            directionality : '{{ App::getLocale() == 'he' ? 'rtl' : 'ltr' }}',
            mentions: {
                delimiter: ['@', '#', '['@if(!empty($model) && $model->entity), '{'@endif],
                delay: 250,
                source: function(query, process, delimiter) {
                    if (delimiter === '#') {
                        $.getJSON('{{ route('search.calendar-months') }}?q='+ query, function(data) {
                            process(data)
                        })
                    } @if(!empty($model) && $model->entity)else if(delimiter === '{') {
                        $.getJSON('{{ route('search.attributes', $model->entity) }}?q='+ query, function(data) {
                            process(data)
                        })
                    }@endif else {
                        if (delimiter === '[') {
                            advancedRequest = true;
                        } else {
                            advancedRequest = false;
                        }
                        $.getJSON('{{ route('search.live') }}?q='+ query + '&new=1', function(data) {
                            process(data)
                        })
                    }
                },
                insert: function(item) {
                    // Attribute
                    if (item.value) {
                        @if (Auth::user()->advancedMentions)
                            return '{attribute:' + item.id + '}';
                        @else
                            return '<a href="#" class="attribute" data-attribute="{attribute:' + item.id + '}">{' + item.name + '}</a>'
                        @endif
                    }
                    else if (item.id) {
                        var mention = '[' + item.model_type + ':' + item.id + ']';
                        @if (Auth::user()->advancedMentions)
                        return mention;
                        @else
                        if (advancedRequest) {
                            return mention;
                        }
                        return '<a href="#" class="mention" data-mention="' + mention + '">' + item.fullname + '</a>';
                        @endif
                    }
                    else if (item.url) {
                        if (item.tooltip) {
                            var str = '<a href="' + item.url + '" title="' + item.tooltip.replace(/["]/g, '\'') + '" data-toggle="tooltip" data-html="true" >' + item.fullname + '</a>';
                            return str;
                        }
                        return '<a href="' + item.url + '">' + item.fullname + '</a>';
                    }
                    else if (item.inject) {
                        return item.inject;
                    }
                    return item.fullname;
                },
                render: function(item) {
                    if (item.value) {
                        return '<li><a href="javascript:;"><span>' + item.name +  (item.value ? ' (' + item.value + ')' : '') + '</span></a></li>';
                    }
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

