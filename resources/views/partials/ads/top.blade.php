<x-ad section="hybrid" :campaign="isset($campaign) ? $campaign : null">
    <div id="subscription-encouragement" class="hidden text-center text-muted my-2" style="background-color:#d4af37; height: 50px; margin:auto; text-align:center;" >
        Hey I'm a hidden div, but you have an Ad-Blocker
    </div>

    
    <div class="ads-space overflow-hidden">
        <div class="vm-placement" id="vm-av" data-format="isvideo"></div>
    </div>
    <p class="text-center text-muted my-2">
        {!! __('misc.ads.remove_v3', [
            'subscribing' => link_to_route('settings.subscription', __('misc.ads.subscribing')),
            'boosting' => link_to('https://kanka.io/premium', __('misc.ads.premium')),
        ]) !!}
    </p>
</x-ad>
