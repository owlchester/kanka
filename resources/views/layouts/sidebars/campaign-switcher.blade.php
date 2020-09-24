<section class="campaign-switcher collapse" id="campaign-switcher">
    <div class="section">{{ __('sidebar.campaign_switcher.created_campaigns') }}</div>

    @if (Auth::check())
        <ul>
            @foreach (\App\Facades\UserCache::campaigns() as $userCampaign)
                @if (!isset($currentCampaign) || ($userCampaign->id != $currentCampaign->id && !\App\Facades\Identity::isImpersonating()))
                    <li>
                        @if ($userCampaign->image)
                            <div class="background-image" style="background-image: url({{ Img::crop(208, 48)->url($userCampaign->image) }})"></div>
                            <div class="background-gradient"></div>
                        @endif
                        <a href="{{ url(App::getLocale() . '/' . $userCampaign->getMiddlewareLink()) }}">
                            {!! $userCampaign->name !!}
                        </a>
                    </li>
                @endif
            @endforeach
            @if (!isset($newCampaign))
            @can('create', \App\Models\Campaign::class)
                <li class="bordered">
                    <a href="{{ !Auth::user()->hasCampaigns() ? route('start') : route('campaigns.create') }}">
                        <i class="fa fa-plus"></i> {{ __('sidebar.campaign_switcher.new_campaign') }}
                    </a>
                </li>
            @endcan
            @endif
        </ul>

        @if (\App\Facades\UserCache::follows()->count() > 0)
            <div class="section">{{ __('sidebar.campaign_switcher.public_campaigns') }}</div>
            <ul>
                @foreach (\App\Facades\UserCache::follows() as $userCampaign)
                    @if (!isset($currentCampaign) || ($userCampaign->id != $currentCampaign->id && !\App\Facades\Identity::isImpersonating()))
                        <li>@if ($userCampaign->image)
                                <div class="background-image" style="background-image: url({{ Img::crop(208, 48)->url($userCampaign->image) }})"></div>
                                <div class="background-gradient"></div>
                            @endif
                            <a href="{{ url(App::getLocale() . '/' . $userCampaign->getMiddlewareLink()) }}">
                                {!! $userCampaign->name !!}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    @endif
</section>
