@extends('layouts.front', [
    'title' => trans('faq.show.title', ['name' => __("faq.$key.question")]),
    'description' => '',
])

@section('og')
    <meta property="og:description" content="{{ __("faq.$key.answer") }}" />
    <meta property="og:url" content="{{ route('faq.show', ['key' => $key, 'slug' => \Illuminate\Support\Str::slug(__('faq.' . $key . '.question'))]) }}" />
@endsection

@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{!! __("faq.$key.question") !!}</h1>
                        <p class="mb-5">{!! nl2br(__("faq.$key.answer", [
                            'patreon' => link_to(config('patreon.url'), 'Patreon', ['target' => '_blank']),
                            'discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank']),
                            'boosters' => link_to_route('front.features', __('front.features.patreon.boosts'), ['#boost']),
                            'public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns')),
                            'lfgm' => link_to('https://lookingforgm.com', 'LookingForGM.com', ['target' => '_blank']),
                        ])) !!}</p>

                        @if ($key == 'permissions')
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/ikNPzNgjYmg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        @elseif ($key == 'attribute-templates')
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/qKnTpuePqUA" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        @elseif ($key == 'visibility')
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/VpY_D2PAguM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        @endif
                        <p><a href="{{ route('faq.index') }}">{{ trans('faq.show.return') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection
