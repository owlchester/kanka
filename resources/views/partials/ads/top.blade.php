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

    <p class="text-center text-muted my-2">
        {!! __('misc.ads.remove_v3', [
            'subscribing' => '<a href="' . route('settings.subscription') . '">' . __('misc.ads.subscribing') . '</a>',
            'boosting' => '<a href="https://kanka.io/premium">' . __('misc.ads.premium') . '</a>',
        ]) !!}
    </p>
</x-ad>
