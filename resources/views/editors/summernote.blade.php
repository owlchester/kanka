@section('scripts')
    @parent
    <script src="{{ config('app.asset_url') }}/vendor/summernote/0.9.1/summernote.min.js" defer></script>

    @vite('resources/js/editors/summernote.js')
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/embed/summernote-embed-plugin.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/summernote-table-headers/summernote-table-headers.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/kanka/summernote-gallery.min.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/summernote-toc-kanka/summernote-toc.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/summernote-aroba-kanka/summernote-aroba.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/summernote-table-ext.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/summernote-image-attribute.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/kanka/summernote-bragi.min.js" defer></script>
    <script src="{{ config('app.asset_url') }}/vendor/summernote/plugin/kanka/summernote-prettify-kanka.min.js" defer></script>

    @if (!in_array(app()->getLocale(), ['en-US', 'en']))
        <script src="{{ config('app.asset_url') }}/vendor/summernote/0.9.1/lang/summernote-{{ app()->getLocale() }}-{{ strtoupper(app()->getLocale()) }}.js" defer></script>
    @endif
@endsection

@section('styles')
@parent
<link href="{{ config('app.asset_url') }}/vendor/summernote/0.9.1/summernote.min.css" rel="stylesheet">

@if (config('app.asset_url'))
    <link href="{{ config('app.asset_url') }}/vendor/bootstrap/bootstrap-summernote.css?v={{ config('app.version') }}" rel="stylesheet">
@else
    <link href="/css/bootstrap-summernote.css?v={{ config('app.version') }}" rel="stylesheet">
@endif
@endsection

@section('modals')
    @parent

    <div
        id="summernote-config"
        data-mention="{{ isset($campaign) ? route('search.live', $campaign) : null }}"
        data-advanced-mention="{{ auth()->user()->alwaysAdvancedMentions() }}"
        data-months="{{ isset($campaign) ? route('search.calendar-months', $campaign) : null }}"
        data-gallery-title="{{ __('sidebar.gallery') }}"
        data-gallery-close="{{ __('crud.actions.close') }}"
        data-gallery-add="{{ __('crud.add') }}"
        data-gallery-select-all="{{ __('general.select_all') }}"
        data-gallery-deselect-all="{{ __('general.deselect_all') }}"
        data-gallery-error="generic.gallery.error"
        data-filesize="{{ Limit::upload() }}"
        data-placeholder="{{ $editorPlaceholder ?? __('crud.placeholders.entry') }}"
        data-dialogs="{{ isset($dialogsInBody) ? '1' : '0' }}"
@if (isset($name) && $name == 'characters')        data-bragi="{{ route('bragi', $campaign) }}"@endif
@if(isset($campaign) && $campaign !== null)
        data-gallery="{{ route('campaign.gallery.summernote', $campaign) }}"
        data-gallery-upload="{{ route('campaign.gallery.ajax-upload', $campaign) }}"
@endif
@if (!empty($model) && !($model instanceof \App\Models\Campaign) && $model->entity)        data-attributes="{{ route('search.attributes', [$campaign, $model->entity]) }}"
@elseif (!empty($entity))        data-attributes="{{ route('search.attributes', [$campaign, $entity]) }}"

@endif
        data-locale="{{ app()->getLocale() }}"></div>

@if(isset($campaign) && $campaign !== null)
    <div class="modal fade" id="campaign-imageupload-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100 rounded-2xl">
                <div class="modal-body text-center">
                    <x-alert type="error" id="campaign-imageupload-error" hidden></x-alert>
                    <x-alert type="error" id="campaign-imageupload-permission" hidden>
                        <p>{!! __('campaigns/gallery.errors.permissions', [
    'permission' => '<code>' . __('campaigns.roles.permissions.actions.gallery.upload') . '</code>']
    ) !!}</p>
                    </x-alert>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
