
@section('styles')
    @parent
    @if (config('app.asset_url'))
        <link href="{{ config('app.asset_url') }}/vendor/bootstrap/bootstrap-summernote.css?v={{ config('app.version') }}" rel="stylesheet">
    @else
        <link href="/css/bootstrap-summernote.css?v={{ config('app.version') }}" rel="stylesheet">
    @endif
@endsection
@section('scripts')
    @parent
    <script src="{{ '/js/tinymce/tinymce.min.js' }}"></script>
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
                "fullpage @if(!empty($campaign)) mention @endif media"
            ],
            toolbar: "undo redo | styleselect | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | hr | link image table media | code fullscreen",
            nanospell_server: "php",
            browser_spellcheck: true,
            relative_urls: false,
            remove_script_host: false,
            branding: false,
            media_live_embeds: true,
            menubar: false,
            content_css: '{{ Vite::asset('resources/css/vendors/tinymce.css') }}',
            extended_valid_elements: "+@[data-mention]",
            @if (!empty($campaign))
            mentions: {
                delimiter: ['@', '#', '['@if(!empty($model) && method_exists($model, 'hasEntity') && $model->hasEntity()), '{'@endif],
                delay: 250,
                source: function(query, process, delimiter) {
                    if (delimiter === '#') {
                        $.getJSON('{{ route('search.calendar-months', $campaign) }}?q='+ query, function(data) {
                            process(data)
                        })
                    } @if(!empty($model) && method_exists($model, 'hasEntity') && $model->hasEntity() && $model->entity)else if(delimiter === '{') {
                        $.getJSON('{{ route('search.attributes', [$campaign, $model->entity]) }}?q='+ query, function(data) {
                            process(data)
                        })
                    }@endif else {
                        if (delimiter === '[') {
                            advancedRequest = true;
                        } else {
                            advancedRequest = false;
                        }
                        $.getJSON('{{ route('search.live', $campaign) }}?q='+ query + '&new=1', function(data) {
                            process(data)
                        })
                    }
                },
                insert: function(item) {
                    // Attribute
                    if (item.value) {
                        @if (auth()->user()->alwaysAdvancedMentions())
                            return '{attribute:' + item.id + '}';
                        @else
                            return '<a href="#" class="attribute attribute-mention" data-attribute="{attribute:' + item.id + '}">{' + item.name + '}</a>'
                        @endif
                    }
                    else if (item.id) {
                        var mention = '[' + item.model_type + ':' + item.id + ']';
                        @if (auth()->user()->alwaysAdvancedMentions())
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
                            var str = '<a href="' + item.url + '" data-title="' + item.tooltip.replace(/["]/g, '\'') + '" data-toggle="tooltip" data-html="true" >' + item.fullname + '</a>';
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
            @endif
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

