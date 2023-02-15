

<div class="modal-body qq-modal-selection">
    <div class="h-8">
    @include('partials.modals.close')
    </div>

    <div class="quick-creator-body">

        @includeWhen(isset($new), 'entities.creator._created', ['success' => $new ?? null])

        <div class="options">
            <div class="popular">
                @include('entities.creator.selection.popular')
            </div>
            <div class="all">
                @include('entities.creator.selection.all')
            </div>
        </div>
    </div>

    <div class="quick-creator-footer mt-4 text-center">

        <p class="help-block my-5">{!! __('entities.creator.missing_v2', [
    'learn-more' => link_to(
        '//docs.kanka.io/en/latest/features/quick-creator.html',
        '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front/newsletter.actions.learn_more'),
        ['target' => '_blank'],
        null,
        false
        )]) !!}</p>
    </div>
</div>

