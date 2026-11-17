@if (isset($new))
<div class="shrink-0 md:hidden">
@endif
<x-dialog.header id="primary-dialog" :mobile-back="true" :mobile-title="__('sidebar.entity-creator')">
    <span class="sr-only">{{ __('Quick creator dialog') }}</span>
</x-dialog.header>
@if (isset($new))
</div>
@endif
<article id="qq-modal-selection" class="p-4 max-md:px-5 md:px-6">
    <div class="quick-creator-body flex flex-col gap-5 w-full">
        @includeWhen(isset($new), 'entities.creator._created', ['success' => $new ?? null, 'dismissable' => false])

        <div class="options flex flex-col gap-10 sm:gap-5 sm:flex-row w-full">
            @if ($popular->isNotEmpty())
            <div class="popular sm:border-r border-base-300 sm:w-60">
                @include('entities.creator.selection.popular')
            </div>
            @endif
            <div class="all w-full">
                @include('entities.creator.selection.all')
            </div>
        </div>
    </div>
</article>
<x-dialog.footer>
    <x-slot name="cancel">
        <p class="text-neutral-content text-xs">{!! __('entities.creator.missing_v2', [
        'learn-more' => '<a href="//docs.kanka.io/en/latest/features/quick-creator.html" class="text-link">' .
            '<i class="fa-regular fa-external-link" aria-hidden="true"></i> ' . __('front/newsletter.actions.learn_more') . '</a>']) !!}</p>
    </x-slot>
</x-dialog.footer>
