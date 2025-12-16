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
                <a rel="nofollow" href="{{ $currentUrl . 'en-US' }}" class="text-link">
                    US English
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'en' }}" class="text-link">
                    UK English
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'pt-BR' }}" class="text-link">
                    Português do Brasil
                </a>
            </li>
        </ul>
        <ul class="list-none p-0 m-0">
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'de' }}" class="text-link">
                    Deutsch
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'fr' }}" class="text-link">
                    Français
                </a>
            </li>
            <li class="py-2">
                <a rel="nofollow" href="{{ $currentUrl . 'es' }}" class="text-link">
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
                    <a rel="nofollow" href="{{ $currentUrl . 'it' }}" class="text-link">
                        Italiano
                    </a>
                </li>
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'pl' }}" class="text-link">
                        Polska
                    </a>
                </li>
            </ul>
            <ul class="list-none p-0 m-0">
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'ru' }}" class="text-link">
                        Pусский
                    </a>
                </li>
                <li class="py-2">
                    <a rel="nofollow" href="{{ $currentUrl . 'sk' }}" class="text-link">
                        Slovenský
                    </a>
                </li>
            </ul>
        </div>
    </div>
</x-dialog>
