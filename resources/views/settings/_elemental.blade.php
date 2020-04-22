<div class="box box-widget widget-user widget-patron">
    <div class="widget-user-header bg-red-active">
        <h3 class="widget-user-username">Elemental</h3>
        <h5 class="widget-user-desc">{{ auth()->user()->currencySymbol() }}25 / {{ __('front.pricing.tier.month') }}</h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png" alt="Elemental">
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.upload_limit') }}</div>
            <div class="col-xs-3 col-sm-4">25 mb</div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.upload_limit_map') }}</div>
            <div class="col-xs-3 col-sm-4">25 mb</div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.discord') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.default_image') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{!! __('front.features.patreon.hall_of_fame', ['link' => link_to_route('front.about', __('teams.hall_of_fame'), ['#patreon'])]) !!}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.api_calls') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.pagination') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.monthly_vote') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.boosts') }}</div>
            <div class="col-xs-3 col-sm-4">10</div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.curation') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.impact') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
    </div>

</div>
