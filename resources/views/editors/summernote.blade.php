@section('scripts')
    @parent
    <script src="/vendor/summernote/summernote.min.js?v={{ config('app.version') }}" defer></script>
    <script src="{{ mix('js/editors/summernote.js') }}" defer></script>
    <script src="/vendor/summernote/plugin/embed/summernote-embed-plugin.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-table-headers/summernote-table-headers.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-gallery.min.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-toc-kanka/summernote-toc.js" defer></script>
    <script src="/vendor/summernote/plugin/spoiler/summernote-spoiler.js" defer></script>
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
        data-advanced-mention="{{ auth()->user()->advancedMentions }}"
        data-months="{{ route('search.calendar-months') }}"
        data-gallery-title="Superboosted Gallery"
        data-gallery-close="{{ __('crud.click_modal.close') }}"
        data-gallery-add="{{ __('crud.add') }}"
        data-gallery-select-all="{{ __('voyager.generic.select_all') }}"
        data-gallery-deselect-all="{{ __('voyager.generic.deselect_all') }}"
        data-gallery-error="generic.gallery.error"
@if(isset($campaign) && $campaign->campaign() !== null)
        data-gallery="{{ $campaign->campaign()->boosted(true) ? route('campaign.gallery.summernote') : null }}"
    @if($campaign->campaign()->boosted(true)) data-gallery-upload="{{ route('campaign.gallery.ajax-upload') }}" @endif
@endif
@if (!empty($model) && !($model instanceof \App\Models\Campaign) && $model->entity)        data-attributes="{{ route('search.attributes', $model->entity) }}"
@elseif (!empty($entity))        data-attributes="{{ route('search.attributes', $entity) }}"

@endif
        data-locale="{{ app()->getLocale() }}"></div>

    <div class="modal fade" id="campaign-imageupload-error" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('campaigns.superboosted.gallery.error.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="superboosted-error">{!! __('campaigns.superboosted.gallery.error.text', [
    'superboosted' => link_to_route('front.features', __('crud.superboosted_campaigns'), '#boost', ['target' => '_blank'])
]) !!}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection
