<div id="language-switcher" class="language-switcher">
    <a href="#" class="btn2 min-h-0 px-3 py-1.5 text-xs" data-toggle="dialog" data-target="language-select-modal" title="{{ __('footer.language-switcher.title') }}">
        <x-icon class="fa-regular fa-language" />
        {{ LaravelLocalization::getCurrentLocaleNative() }}
        <x-icon class="fa-solid fa-chevron-down text-[10px] opacity-60" />
    </a>
</div>
