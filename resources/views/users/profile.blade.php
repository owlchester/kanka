<?php /** @var \App\Models\User $user */?>
@extends('layouts.front', [
    'title' => __('users/profile.title', ['name' => $user->displayName()]),
    'skipPerf' => true,
    'ogImage' => (bool) $user->avatar,
])

@section('og')
    @if (!empty($user->profile['bio']))<meta property="og:description" content="{{ $user->profile['bio'] }}" />@endif
    <meta property="og:url" content="{{ route('users.profile', $user) }}" />
    @if ($user->hasAvatar())
        <meta property="og:image" content="{{ $user->getAvatarUrl(200)  }}" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="200" />
    @endif
@endsection

@section('content')
    <section class="bg-purple text-white gap-16">
        <div class="px-6 py-20 lg:max-w-7xl mx-auto flex flex-col gap-8">
            <div class="flex flex-wrap md:flex-no-wrap gap-10 items-center justify-center">
                <div class="grow flex flex-col gap-3">
                    @if ($user->isBanned())
                        <div class="p-4 bg-red-800 rounded-xl text-white">
                            <i class="fa-regular fa-ban"></i>
                            {{__('users/profile.fields.banned')}}
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <h1 class="text-md">
                                {!! $user->displayName() !!}
                            </h1>
                            @isset($user->settings['pronouns'])
                                <span class="text-light text-base">{{ $user->settings['pronouns']}}</span>
                            @endif
                        </div>
                        @if (!empty($user->profile['bio']))
                            <p class="">
                                {!! nl2br($user->profile['bio']) !!}
                            </p>
                        @endif

                        <div class="flex flex-wrap gap-3">
                            @if ($discord = $user->discord())
                                <span class="btn-round rounded-full btn-sm" data-title="Discord" data-toggle="tooltip">
                                    <x-icon class="fa-brands fa-discord" />
                                    {{ $discord->settings['username'] }}
                                </span>
                            @endif

                            @if (isset($user->settings['link']))
                                <a class="btn-round rounded-full btn-sm" href="{{ $user->settings['link'] }}" title="Social profile" data-toggle="tooltip">
                                    <x-icon class="fa-regular fa-link" />
                                    {{ \Illuminate\Support\Str::after($user->settings['link'], '://') }}
                                </a>
                            @endif

                            @if ($user->hasPlugins())
                                <a class="btn-round rounded-full btn-sm" href="{{ config('marketplace.url') . '/profiles/' . $user->id }}" title="Marketplace" data-toggle="tooltip">
                                    <x-icon class="fa-solid fa-shop" />
                                    {{ __('footer.plugins') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="w-60 profile-pledge flex flex-col items-center justify-center gap-3">
                    @if ($user->isElemental())
                        <a href="{{ Domain::toFront('hall-of-fame') }}">
                            <img src="https://th.kanka.io/auu1F0KxCXOalmPB9I_FY4E3Ag8=/150x150/smart/src/app/tiers/elemental.png"
                                 class="profile-subscriber" title="Elemental" alt="Elemental subscription" />
                        </a>
                        <div class="text-uppercase text-md">Elemental</div>
                    @elseif ($user->isWyvern())
                        <a href="{{ Domain::toFront('hall-of-fame') }}">
                            <img src="https://th.kanka.io/ua5Q1aTly0Z0vx7GCN_qPQ5i650=/150x150/smart/src/app/tiers/wyvern.png"
                                class="profile-subscriber" title="Wyvern" alt="Wyvern subscription" />
                        </a>
                        <div class="text-uppercase text-md">Wyvern</div>

                    @elseif ($user->isOwlbear())
                        <a href="{{ Domain::toFront('hall-of-fame') }}">
                        <img src="https://th.kanka.io/gC3TXbW4neasqwZzH9lcTixg7Lo=/150x150/smart/src/app/tiers/owlbear.png"
                                 class="profile-subscriber" title="Owlbear" alt="Owlbear subscription" />
                        </a>
                        <div class="text-uppercase text-md">Owlbear</div>
                    @elseif ($user->hasRole('admin'))
                        <a href="{{ Domain::toFront('about') }}">
                            <img src="https://th.kanka.io/BJcn1N6rdxAoCPVtYyGHB7s5VO0=/150x150/smart/src/app/logos/icon.png"
                                 class="profile-subscriber" title="Kanka Team" alt="Kanka Logo" />
                        </a>
                        <div class="text-uppercase text-md text-center">
                            Kanka Team
                        </div>
                    @else
                        <img src="https://th.kanka.io/m4UFnMHPEFuUvSOdk1uJ65MkSTs=/150x150/smart/src/app/tiers/kobold.png"
                                 class="profile-subscriber" title="Kobold" alt="Kobold free user" />
                        <div class="text-uppercase  text-md">Kobold</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="lg:max-w-7xl lg:mx-auto flex flex-col gap-10 lg:gap-10 py-10 lg:py-12 px-4 xl:px-0 text-dark" id="profile">

        <div class="flex gap-10 w-full justify-between flex-wrap lg:flex-no-wrap">
            <div class="grow flex flex-col gap-5">
                @if (!$user->isBanned() && !$campaigns->isEmpty())
                    <h2>{{ __('users/profile.fields.public_campaigns') }}</h2>

                    <div class="flex gap-5 flex-wrap">
                        @foreach ($campaigns as $campaign)
                            @include('front._campaign', ['campaign' => $campaign, 'featured' => false])
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="w-60 flex flex-col gap-10">
                <div class="flex flex-col md:items-center">
                    <p>
                        {!! __('users/profile.fields.member_since', ['date' => '</p><p class="mb-3 text-light">' . $user->created_at->format('M d, Y')]) !!}
                    </p>

                    @if ($user->subscribed('kanka'))
                        <p>
                            {!! __('users/profile.fields.subscriber_since', ['date' => '</p><p class="mb-3 text-light">' . $user->subscription('kanka')->created_at->format('M d, Y')]) !!}
                        </p>
                    @endif

                    <p>
                        {!! __('users/profile.fields.entities_created', [
'count' => '</p><p class="text-light mb-3">' . $user->createdEntitiesCount(),
'help' => '<i class="fa-solid fa-question-circle" title="' . __('users/profile.helpers.entities_created') . '"></i>',
]) !!}</p>
                </div>


                @includeWhen(!$user->isBanned() && $user->hasAchievements(), 'users._badges')
            </div>
        </div>
    </section>
@endsection
