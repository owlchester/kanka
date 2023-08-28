<div class="modal-body qq-modal-selection">
    <div class="h-8">
    @include('partials.modals.close')
    </div>

    <div class="quick-creator-body">
        @includeWhen(isset($new), 'entities.creator._created', ['success' => $new ?? null])

        <div class="options">
            <div class="popular pr-4">
                @include('entities.creator.selection.popular')
            </div>
            <div class="all">
                @include('entities.creator.selection.all')
            </div>
        </div>
    </div>

    <div class="quick-creator-footertext-center mt-5">
        <p class="m-4 text-neutral-content text-xs">{!! __('entities.creator.missing_v2', [
    'learn-more' => link_to(
        '//docs.kanka.io/en/latest/features/quick-creator.html',
        '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front/newsletter.actions.learn_more'),
        ['target' => '_blank'],
        null,
        false
        )]) !!}</p>
    </div>
</div>

