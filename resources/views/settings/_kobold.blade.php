<div class="box box-widget widget-user widget-patron">
    <div class="widget-user-header bg-orange-active">
        <h3 class="widget-user-username">Kobold</h3>
        <h5 class="widget-user-desc">{{ auth()->user()->currencySymbol() }}1 / {{ __('front.pricing.tier.month') }}</h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/kobold-325.png" alt="Kobold">
    </div>
    <div class="box-body">
        <div class="row">

            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.upload_limit') }}</div>
            <div class="col-xs-3 col-sm-4">8 mb</div>

            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.upload_limit_map') }}</div>
            <div class="col-xs-3 col-sm-4">10 mb</div>

            <div class="col-xs-9 col-sm-8">{{ __('front.features.patreon.discord') }}</div>
            <div class="col-xs-3 col-sm-4"><i class="fa fa-check-circle"></i></div>
        </div>
        <p class="help-block margin-top">{{ __('settings.patreon.wrong_pledge') }}</p>
    </div>

</div>
