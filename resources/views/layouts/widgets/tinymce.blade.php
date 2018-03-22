@section('scripts')
    <script>
        var editor_config = {
            path_absolute : "/",
            language: '{{ App::getLocale() }}',
            selector: "textarea.html-editor",
            plugins: [
                "save advlist autolink lists link image charmap hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking table contextmenu directionality",
                "emoticons paste textcolor colorpicker textpattern",
                "fullpage help mention"
            ],
            toolbar: "save undo redo | styleselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | ltr rtl | bullist numlist outdent indent removeformat formatselect| link image media | emoticons charmap | | forecolor backcolor",
            nanospell_server:"php",
            browser_spellcheck: true,
            relative_urls: false,
            remove_script_host: false,
            branding: false,
            mentions: {
                source: function(query, process, delimiter) {
                    if (delimiter === '@') {
                        $.getJSON('{{ route('search.mentions') }}', function(data) {
                            console.log('data', data);
                            console.log('process', process);
                            process(data)
                        })
                    }
                },
                insert: function(item) {
                    console.log('insert', item);
                    return '<a href="' + item.url + '">' + item.name + '</a>';
                }
            }
        };

        tinymce.init(editor_config);
    </script>
@endsection

@section('styles')
    <script src="{{asset('js/tinymce/jquery.tinymce.min.js')}}"></script>
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
@endsection