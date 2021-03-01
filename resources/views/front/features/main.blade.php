<div class="row">
    <div class="col-lg-4 col-6">
        @include('front.features._free')
    </div>
    <div class="col-lg-4 col-6">
        @include('front.features._collaborative')
    </div>
    <div class="col-lg-4 col-6">
        @include('front.features._updates')
    </div>

    <div class="col-lg-4 col-6">
        @include('front.features._worldbuilding')
    </div>
    <div class="col-lg-4 col-6">
        @include('front.features._modular')
    </div>
    <div class="col-lg-4 col-6">
        @include('front.features._rpg')
    </div>
</div>
<div class="pricing text-center">
    <a href="{{ route('front.worldbuilder-features') }}" class="btn btn-primary btn-lg mr-sm-3 mr-md-5 mb-3 mb-sm-0 d-block d-sm-inline-block">{{ __('front.features.actions.worldbuilder') }}
    </a>

    <a href="{{ route('front.gm-features') }}" class="btn btn-primary btn-lg d-block d-sm-inline-block">{{ __('front.features.actions.rpg') }}
    </a>
</div>
