@section('scripts')
    @parent
    <script src="/vendor/summernote/summernote.min.js?v={{ config('app.version') }}" defer></script>

    @vite('resources/js/editors/summernote.js')
    <script src="/vendor/summernote/plugin/embed/summernote-embed-plugin.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-table-headers/summernote-table-headers.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-gallery-kanka.min.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-toc-kanka/summernote-toc.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-aroba-kanka/summernote-aroba.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-table-ext.js" defer></script>
    <script src="/vendor/summernote/plugin/summernote-image-attribute.js" defer></script>
    <script src="/vendor/summernote/plugin/kanka/summernote-bragi-kanka.min.js" defer></script>
    <script src="/vendor/summernote/plugin/kanka/summernote-prettify-kanka.min.js" defer></script>
{{--    <script src="/vendor/summernote/plugin/rtl/summernote-ext-rtl.js" defer></script>--}}

    @if (app()->getLocale() == 'ca')
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
        data-mention="{{ route('search.live', $campaign) }}"
        data-advanced-mention="{{ auth()->user()->alwaysAdvancedMentions() }}"
        data-months="{{ route('search.calendar-months', $campaign) }}"
        data-gallery-title="Superboosted Gallery"
        data-gallery-close="{{ __('crud.click_modal.close') }}"
        data-gallery-add="{{ __('crud.add') }}"
        data-gallery-select-all="{{ __('general.select_all') }}"
        data-gallery-deselect-all="{{ __('general.deselect_all') }}"
        data-gallery-error="generic.gallery.error"
        data-filesize="{{ auth()->user()->maxUploadSize() }}"
        data-placeholder="{{ __('crud.placeholders.entry') }}"
        data-dialogs="{{ isset($dialogsInBody) ? '1' : '0' }}"
@if (isset($name) && $name == 'characters')        data-bragi="{{ route('bragi') }}"@endif
@if(isset($campaignService) && $campaignService->campaign() !== null)
        data-gallery="{{ $campaignService->campaign()->superboosted() ? route('campaign.gallery.summernote', $campaign) : null }}"
    @if($campaignService->campaign()->superboosted()) data-gallery-upload="{{ route('campaign.gallery.ajax-upload', $campaign) }}" @endif
@endif
@if (!empty($model) && !($model instanceof \App\Models\Campaign) && $model->entity)        data-attributes="{{ route('search.attributes', [$campaign, $model->entity]) }}"
@elseif (!empty($entity))        data-attributes="{{ route('search.attributes', [$campaign, $entity]) }}"

@endif
        data-locale="{{ app()->getLocale() }}"></div>

@if(isset($campaignService) && $campaignService instanceof \App\Services\CampaignService && $campaignService->campaign() !== null)
    <div class="modal fade" id="campaign-imageupload-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100 rounded-2xl">
                <div class="modal-body text-center">
                    <div id="campaign-imageupload-boosted">
                        <x-dialog.close />

                        <x-cta :campaign="$campaign" image="0" superboost="1">
                            <p>{{ __('campaigns/gallery.pitch') }}</p>
                        </x-cta>
                    </div>
                    <x-alert type="error" id="campaign-imageupload-error" :hidden="true"></x-alert>
                    <x-alert type="error" id="campaign-imageupload-permission" :hidden="true"></x-alert>
                        {!! __('campaigns/gallery.errors.permissions', [
    'permission' => '<code>' . __('campaigns.roles.permissions.actions.gallery') . '</code>']
    ) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
