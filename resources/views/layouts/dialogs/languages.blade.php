<x-dialog id="language-select-modal" :title="__('footer.language-switcher.title')">
    @php
        $currentUrl = url()->full();
        if (\Illuminate\Support\Str::contains($currentUrl, '?')) {
            $currentUrl .= '&lang=';
        } else {
            $currentUrl .= '?lang=';
        }
    @endphp
    <div class="grid grid-cols-2 gap-4">
        <ul class="list-none p-0 m-0">
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'en-US' }}" rel="nofollow">
                    US English
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'en' }}" >
                    UK English
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'pt-BR' }}">
                    Português do Brasil
                </a>
            </li>
        </ul>
        <ul class="list-none p-0 m-0">
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'de' }}">
                    Deutsch
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'fr' }}">
                    Français
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'es' }}">
                    Español
                </a>
            </li>
        </ul>
    </div>
    <div class="text-left w-full">
        {{ __('footer.language-switcher.other') }}
    </div>
    <div class="w-full">
        <div class="grid grid-cols-2 gap-4">
            <ul class="list-none p-0 m-0">
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'it' }}">
                        Italiano
                    </a>
                </li>
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'pl' }}">
                        Polska
                    </a>
                </li>
            </ul>
            <ul class="list-none p-0 m-0">
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'ru' }}">
                        Pусский
                    </a>
                </li>
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'sk' }}">
                        Slovenský
                    </a>
                </li>
            </ul>
        </div>
    </div>
</x-dialog>
