<div class="box box-widget widget-user widget-patron">
    <div class="widget-user-header bg-green-active">
        <h3 class="widget-user-username">Owlbear</h3>
        <h5 class="widget-user-desc">{{ auth()->user()->currencySymbol() }}5 / {{ __('front.pricing.tier.month') }}</h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png" alt="Owlbear">
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.upload_limit') }}</div>
            <div class="col-xs-3 col-sm-4">8 mb</div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.upload_limit_map') }}</div>
            <div class="col-xs-3 col-sm-4">10 mb</div>
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
            <div class="col-xs-3 col-sm-4">3</div>
        </div>
    </div>

</div>
