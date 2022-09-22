@extends('layouts.front', [
    'title' => __('front/hall-of-fame.title'),
    'active' => 'hall-of-fame',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('front/hall-of-fame.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.hall-of-fame') }}" />
@endsection

@section('content')

    <section class="subscribers">
        <div class="container">
            <div class="section-body">
                <div class="mb-5 pb-2">
                    <h1 class="display-4">{{ __('front/hall-of-fame.title', ['kanka' => config('app.name')]) }}</h1>
                    <p class="lead">{!! __('front/hall-of-fame.description', [
    'kanka' => config('app.name'),
    'features' => link_to_route('front.features', __('front.menu.features'))
]) !!}</p>
                </div>

                <div class="bg-white rounded shadow-sm py-4 px-4 hover-focus mb-5" id="elementals">
                    <div class=" text-center">
                        <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png" alt="Elemental" width="150">
                        <h5 class="mb-1 text-uppercase">Elemental</h5>
                    </div>

                    <div class="row text-center">
                        @foreach (\Illuminate\Support\Arr::get($subscribers, 'Elemental', []) as $user)
                            <div class="col-lg-3 col-md-4 col-6 text-truncate">{{ $user }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded shadow-sm py-4 px-4 hover-focus mb-5" id="wyverns">
                    <div class=" text-center">
                        <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/wyvern-325.png" alt="Wyvern" width="125">
                        <h5 class="mb-1 text-uppercase">Wyvern</h5>
                    </div>

                    <div class="row text-center">
                        @foreach (\Illuminate\Support\Arr::get($subscribers, 'Wyvern', []) as $user)
                            <div class="col-lg-3 col-md-4 col-6 text-truncate">{{ $user }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded shadow-sm py-4 px-4 hover-focus mb-5" id="owlbears">
                    <div class=" text-center">
                        <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png" alt="Owlbear" width="100">
                        <h5 class="mb-1 text-uppercase">Owlbear</h5>
                    </div>

                    <div class="row text-center">
                        @foreach (\Illuminate\Support\Arr::get($subscribers, 'Owlbear', []) as $user)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-truncate">{{ $user }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded shadow-sm py-4 px-4 hover-focus mb-5" id="goblins">
                    <div class="mb-1 text-center">
                        <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/goblin-325.png" alt="Goblin" width="80">
                        <h5 class="text-uppercase">Goblin</h5>
                        <p class="text-center font-italic">{{ __('front/hall-of-fame.legacy', ['kanka' => config('app.name')]) }}</p>
                    </div>

                    <div class="row text-center">
                        @foreach (\Illuminate\Support\Arr::get($subscribers, 'Goblin', []) as $user)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-truncate">{{ $user }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
