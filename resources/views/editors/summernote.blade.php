
@section('scripts')
    @parent
    <script src="/vendor/summernote/summernote.min.js?v={{ config('app.version') }}" defer></script>
    <script src="{{ mix('js/editors/summernote.js') }}" defer></script>
    <script src="/vendor/summernote/plugin/embed/summernote-embed-plugin.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-table-headers/summernote-table-headers.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-gallery.min.js" defer></script>
{{--    <script src="/vendor/summernote/plugin/rtl/summernote-ext-rtl.js" defer></script>--}}

    @if (app()->getLocale() == 'he')
        <script src="/vendor/summernote/lang/summernote-he-IL.js" defer></script>
    @elseif (app()->getLocale() == 'ca')
        <script src="/vendor/summernote/lang/summernote-ca-ES.js" defer></script>
    @elseif (!in_array(app()->getLocale(), ['en-US', 'en']))
        <script src="/vendor/summernote/lang/summernote-{{ app()->getLocale() }}-{{ strtoupper(app()->getLocale()) }}.js" defer></script>
    @endif
@endsection

@section('styles')
@parent
<link href="/vendor/summernote/summernote.min.css" rel="stylesheet">
@endsection

@section('modals')
    @parent
    <div
        id="summernote-config"
        data-mention="{{ route('search.live') }}"
        data-advanced-mention="{{ Auth::user()->advancedMentions }}"
        data-months="{{ route('search.calendar-months') }}"
        data-gallery="{{ $campaign->campaign()->boosted(true) ? route('campaign.gallery.summernote') : null }}"
        data-gallery-title="Superboosted Gallery"
        data-gallery-close="{{ __('crud.click_modal.close') }}"
        data-gallery-add="{{ __('crud.add') }}"
        data-gallery-select-all="{{ __('voyager.generic.select_all') }}"
        data-gallery-deselect-all="{{ __('voyager.generic.deselect_all') }}"
        data-gallery-error="SuperbAAGallery"
@if (!empty($model) && $model->entity)        data-attributes="{{ route('search.attributes', $model->entity) }}"
@elseif (!empty($entity))        data-attributes="{{ route('search.attributes', $entity) }}"

@endif
        data-locale="{{ app()->getLocale() }}"></div>
@endsection
