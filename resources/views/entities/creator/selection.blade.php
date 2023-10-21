<x-dialog.header>

</x-dialog.header>
<article id="qq-modal-loading" style="display: none">
    <div class="text-center text-4xl">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        <span class="sr-only">Loading...</span>
    </div>
</article>
<article id="qq-modal-form" style="display: none">
</article>
<div class="container">
    <article id="qq-modal-selection">
        <div class="quick-creator-body flex flex-col gap-5">
            @includeWhen(isset($new), 'entities.creator._created', ['success' => $new ?? null, 'dismissable' => false])

            <div class="options flex flex-col gap-5 sm:flex-row">
                <div class="popular pr-4 sm:w-60">
                    @include('entities.creator.selection.popular')
                </div>
                <div class="all">
                    @include('entities.creator.selection.all')
                </div>
            </div>
        </div>

        <div class="quick-creator-footertext-center">
            <p class="m-4 text-neutral-content text-xs">{!! __('entities.creator.missing_v2', [
        'learn-more' => link_to(
            '//docs.kanka.io/en/latest/features/quick-creator.html',
            '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front/newsletter.actions.learn_more'),
            ['target' => '_blank'],
            null,
            false
            )]) !!}</p>
        </div>
    </article>
</div>
