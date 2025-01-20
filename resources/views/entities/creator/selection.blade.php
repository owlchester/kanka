@if (!isset($new))
<x-dialog.header>
    <span class="sr-only" id="dialog-label-primary-dialog">{{ __('Quick creator dialog') }}</span>
</x-dialog.header>
@endif
<article id="qq-modal-loading" class="!hidden">
    <div class="text-center text-4xl">
        <x-icon class="fa-solid fa-spinner fa-spin" />
        <span class="sr-only">Loading...</span>
    </div>
</article>
<article id="qq-modal-form" class="!hidden">
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
        'learn-more' => '<a href="//docs.kanka.io/en/latest/features/quick-creator.html" target="_blank">' .
            '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front/newsletter.actions.learn_more') . '</a>']) !!}</p>
        </div>
    </article>
</div>
