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
            <div class="flex gap-10">
                <div class="grow flex flex-col gap-3">
                    <h1 class="">{!! $user->displayName() !!}</h1>
                    @if ($user->isBanned())
                        <x-alert type="warning">
                            {{__('users/profile.fields.banned')}}
                        </x-alert>
                    @endif
                    @if (!empty($user->profile['bio']))
                        <p class="text-light">
                            {!! nl2br($user->profile['bio']) !!}
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                    @if ($discord = $user->discord())
                        <span class="btn-round rounded-full" data-title="Discord" data-toggle="tooltip">
                            <x-icon class="fa-brands fa-discord" />
                            {{ $discord->settings['username'] }}
                        </span>
                    @endif

                    @if ($user->hasPlugins())
                        <a class="btn-round rounded-full" href="{{ config('marketplace.url') . '/profiles/' . $user->id }}" title="Marketplace" data-toggle="tooltip">
                            <x-icon class="fa-solid fa-shop" />
                            {{ __('footer.plugins') }}
                        </a>
                    @endif

                    @if (auth()->check() && !\App\Facades\Identity::isImpersonating() && auth()->user()->id === $user->id)
                        <a href="{{ route('settings.profile') }}" class="btn-round rounded-full" target="_blank" data-title="{{ __('crud.edit') }}" data-toggle="tooltip">
                            <x-icon class="pencil" />
                            {{ __('settings.profile.actions.update_profile') }}
                        </a>
                    @endif
                    </div>
                </div>
                <div class="w-60 profile-pledge flex flex-col items-center justify-center gap-3">
                    @if ($user->isElemental())
                        <a href="https://kanka.io/hall-of-fame">
                            <img src="https://th.kanka.io/auu1F0KxCXOalmPB9I_FY4E3Ag8=/150x150/smart/src/app/tiers/elemental.png"
                                 class="profile-subscriber" title="Elemental" />
                        </a>
                        <div class="text-uppercase text-md">Elemental</div>
                    @elseif ($user->isWyvern())
                        <a href="https://kanka.io/hall-of-fame">
                            <img src="https://th.kanka.io/ua5Q1aTly0Z0vx7GCN_qPQ5i650=/150x150/smart/src/app/tiers/wyvern.png"
                                class="profile-subscriber" title="Wyvern" />
                        </a>
                        <div class="text-uppercase text-md">Wyvern</div>

                    @elseif ($user->isOwlbear())
                        <a href="https://kanka.io/hall-of-fame">
                        <img src="https://th.kanka.io/gC3TXbW4neasqwZzH9lcTixg7Lo=/150x150/smart/src/app/tiers/owlbear.png"
                                 class="profile-subscriber" title="Owlbear" />
                        </a>
                        <div class="text-uppercase text-md">Owlbear</div>
                    @elseif ($user->hasRole('admin'))
                        <a href="https://kanka.io/about">
                            <img src="https://th.kanka.io/BJcn1N6rdxAoCPVtYyGHB7s5VO0=/150x150/smart/src/app/logos/icon.png"
                                 class="profile-subscriber" title="Kanka Team" />
                        </a>
                        <div class="text-uppercase text-md text-center">
                            Kanka Team
                        </div>
                    @else
                        <img src="https://th.kanka.io/m4UFnMHPEFuUvSOdk1uJ65MkSTs=/150x150/smart/src/app/tiers/kobold.png"
                                 class="profile-subscriber" title="Kobold" />
                        <div class="text-uppercase  text-md">Kobold</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="lg:max-w-7xl lg:mx-auto flex flex-col gap-10 lg:gap-10 py-10 lg:py-12 px-4 xl:px-0 text-dark" id="profile">

        <div class="flex gap-10 w-full">
            <div class="grow">
                @if (!$campaigns->isEmpty())
                    <h1>{{ __('users/profile.fields.public_campaigns') }}</h1>

                    <div class="flex gap-5 flex-wrap">
                        @foreach ($campaigns as $campaign)
                            <div class="">
                                @include('front._campaign', ['campaign' => $campaign, 'featured' => false])
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="w-60 flex flex-col gap-10">
                <div class="flex flex-col text-center">
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


                @includeWhen($user->hasAchievements(), 'users._badges')
            </div>
        </div>
    </section>
@endsection
