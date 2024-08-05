<x-ad section="hybrid" :campaign="isset($campaign) ? $campaign : null">
    <div class="ads-space overflow-hidden">
        <div class="vm-placement" id="vm-av" data-format="isvideo"></div>
    </div>
    <div id="adblock-plea" class="hidden rounded p-4 w-full shadow-xs bg-box">
        <div class="flex md:grid md:grid-cols-2 gap-5 italic text-muted">
            <p>In the land of worldbuilding, where ads once reigned free,<br />
                A blocker arose, to users' glee.<br />
                But behind the shield, a website's plight,<br />
                Features dimmed, in the absence of light.
            </p>

            <p>Creators strive, their stories to tell,<br />
                But without ads, it's a harder sell.<br />
                So spare a thought, for the content you view,<br />
                Let ads play their part, and Kanka will thank you.
            </p>
        </div>
    </div>

    @php
    $min = 4.16;
    $currency = 'USD';
    $country = 'US';
    if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) {
        $country = mb_substr($_SERVER["HTTP_CF_IPCOUNTRY"], 0, 6);
    }
    $euro = [
        // EuroZone
        'AT', 'BE', 'HR', 'CY', 'EE', 'FI', 'FR', 'DE', 'GR', 'IE',
        'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PT', 'SI', 'SK', 'ES',
        // Pegged to the EUR
        'DK',
    ];
    if (in_array($country, $euro)) {
        $currency = 'EUR';
    }
    elseif ($country === 'BR') {
        $min = 16.66;
        $currency = 'BRL';
    }
    @endphp
    <p class="text-center text-muted my-2">
        {!! __('misc.ads.remove_v4', [
            'subscribing' => '<a href="' . route('settings.subscription') . '">' . __('misc.ads.subscribing') . '</a>',
            'premium' => '<a href="https://kanka.io/premium">' . __('misc.ads.premium') . '</a>',
            'currency' => $currency,
            'price' => $min,
        ]) !!}
    </p>
</x-ad>
