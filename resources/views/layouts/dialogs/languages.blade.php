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
                <a rel="alternate" hreflang="en-US" href="{{ $currentUrl . 'en-US' }}" rel="nofollow">
                    US English
                </a>
            </li>
            <li class="py-2">
                <a rel="alternate" hreflang="en" href="{{ $currentUrl . 'en' }}" >
                    UK English
                </a>
            </li>
            <li class="py-2">
                <a rel="alternate" hreflang="pt-BR" href="{{ $currentUrl . 'pt-BR' }}">
                    Português do Brasil
                </a>
            </li>
        </ul>
        <ul class="list-none p-0 m-0">
            <li class="py-2">
                <a rel="alternate" hreflang="de" href="{{ $currentUrl . 'de' }}">
                    Deutsch
                </a>
            </li>
            <li class="py-2">
                <a rel="alternate" hreflang="fr" href="{{ $currentUrl . 'fr' }}">
                    Français
                </a>
            </li>
            <li class="py-2">
                <a rel="alternate" hreflang="es" href="{{ $currentUrl . 'es' }}">
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
                    <a rel="alternate" hreflang="it" href="{{ $currentUrl . 'it' }}">
                        Italiano
                    </a>
                </li>
                <li class="py-2">
                    <a rel="alternate" hreflang="pl" href="{{ $currentUrl . 'pl' }}">
                        Polska
                    </a>
                </li>
            </ul>
            <ul class="list-none p-0 m-0">
                <li class="py-2">
                    <a rel="alternate" hreflang="ru" href="{{ $currentUrl . 'ru' }}">
                        Pусский
                    </a>
                </li>
                <li class="py-2">
                    <a rel="alternate" hreflang="sk" href="{{ $currentUrl . 'sk' }}">
                        Slovenský
                    </a>
                </li>
            </ul>
        </div>
    </div>
</x-dialog>
