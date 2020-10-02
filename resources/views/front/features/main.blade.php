<div class="row">
    <div class="col-lg-4 col-md-6">
        @include('front.features._free')
    </div>
    <div class="col-lg-4 col-md-6">
        @include('front.features._collaborative')
    </div>
    <div class="col-lg-4 col-md-6">
        @include('front.features._updates')
    </div>

    <div class="col-lg-4 col-md-6">
        @include('front.features._worldbuilding')
    </div>
    <div class="col-lg-4 col-md-6">
        @include('front.features._modular')
    </div>
    <div class="col-lg-4 col-md-6">
        @include('front.features._rpg')
    </div>
</div>
<div class="row pricing">
    <div class="col-md-6 text-right">

        <a href="{{ route('front.worldbuilder-features') }}" class="btn btn-primary btn-lg mb-2">{{ __('front.features.actions.worldbuilder') }}
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('front.gm-features') }}" class="btn btn-primary btn-lg">{{ __('front.features.actions.rpg') }}
        </a>
    </div>
</div>
