

    <div class="">{{ __('tiers.features.file_size', ['size' => '1 MB']) }}</div>
    <div class="">{{ __('tiers.features.file_size', ['size' => '8 MB']) }}</div>
    <div class="">{{ __('tiers.features.file_size', ['size' => '15 MB']) }}</div>
    <div class="">{{ __('tiers.features.file_size', ['size' => '25 MB']) }}</div>


    <div class="">{{ __('tiers.features.map_size', ['size' => '3 MB']) }}</div>
    <div class="">{{ __('tiers.features.map_size', ['size' => '10 MB']) }}</div>
    <div class="">{{ __('tiers.features.map_size', ['size' => '20 MB']) }}</div>
    <div class="">{{ __('tiers.features.map_size', ['size' => '50 MB']) }}</div>


    <div class="">{{ __('tiers.features.pagination', ['amount' => 45]) }}</div>
    <div class="">{{ __('tiers.features.pagination', ['amount' => 100]) }}</div>
    <div class="">{{ __('tiers.features.pagination', ['amount' => 100]) }}</div>
    <div class="">{{ __('tiers.features.pagination', ['amount' => 100]) }}</div>

@if (auth()->user()->hasBoosterNomenclature())

    <div class=""></div>
    <div class=""><i class="fa-solid fa-rocket text-boost" aria-hidden="true"></i>
        {!! link_to('https://kanka.io/premium', 3 . ' ' . __('tiers.features.boosters'), '', ['target' => '_blank']) !!}
    </div>
    <div class=""><i class="fa-solid fa-rocket text-boost" aria-hidden="true"></i>
        {!! link_to('https://kanka.io/premium', 6 . ' ' . __('tiers.features.boosters'), '', ['target' => '_blank']) !!}
    </div>
    <div class=""><i class="fa-solid fa-rocket text-boost" aria-hidden="true"></i>
        {!! link_to('https://kanka.io/premium', 10 . ' ' . __('tiers.features.boosters'), '', ['target' => '_blank']) !!}
    </div>

@else

    <div class=""></div>
    <div class=""><i class="fa-solid fa-rocket text-boost" aria-hidden="true"></i>
        {!! link_to('https://kanka.io/premium', 1 . ' ' . __('concept.premium-campaign'), '', ['target' => '_blank']) !!}
    </div>
    <div class=""><i class="fa-solid fa-rocket text-boost" aria-hidden="true"></i>
        {!! link_to('https://kanka.io/premium', 3 . ' ' . __('concept.premium-campaigns'), '', ['target' => '_blank']) !!}
    </div>
    <div class=""><i class="fa-solid fa-rocket text-boost" aria-hidden="true"></i>
        {!! link_to('https://kanka.io/premium', 7 . ' ' . __('concept.premium-campaigns'), '', ['target' => '_blank']) !!}
    </div>

@endif

    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.no_ads') }}</div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.no_ads') }}</div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.no_ads') }}</div>


    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.discord') }}</div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.discord') }}</div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.discord') }}</div>


    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {!! link_to('https://kanka.io/hall-of-fame', __('tiers.features.hall_of_fame'), null, ['target' => '_blank']) !!}</div>
    <div class=""><i class="fa-solid fa-check"></i> {!! link_to('https://kanka.io/hall-of-fame', __('tiers.features.hall_of_fame'), null, ['target' => '_blank']) !!}</div>
    <div class=""><i class="fa-solid fa-check"></i> {!! link_to('https://kanka.io/hall-of-fame', __('tiers.features.hall_of_fame'), null, ['target' => '_blank']) !!}</div>


    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.nice_image') }}</div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.nice_image') }}</div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.nice_image') }}</div>


    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), null, ['target' => '_blank']) !!}</div>
    <div class=""><i class="fa-solid fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), null, ['target' => '_blank']) !!}</div>
    <div class=""><i class="fa-solid fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), null, ['target' => '_blank']) !!}</div>


    <div class=""></div>
    <div class=""></div>
    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.vote_influence') }}</div>


    <div class=""></div>
    <div class=""></div>
    <div class=""></div>
    <div class=""><i class="fa-solid fa-check"></i> {{ __('tiers.features.feature_influence') }}</div>


    <div class="">
        <a href="{{ route('larecipe.index') }}" target="_blank">
            {{ __('tiers.features.api_requests', ['amount' => 30]) }}
        </a>
    </div>
    <div class="">
        <a href="{{ route('larecipe.index') }}" target="_blank">
            {{ __('tiers.features.api_requests', ['amount' => 90]) }}
        </a>
    </div>
    <div class="">
        <a href="{{ route('larecipe.index') }}" target="_blank">
            {{ __('tiers.features.api_requests', ['amount' => 90]) }}
        </a>
    </div>
    <div class="">
        <a href="{{ route('larecipe.index') }}" target="_blank">
            {{ __('tiers.features.api_requests', ['amount' => 90]) }}
        </a>
    </div>

