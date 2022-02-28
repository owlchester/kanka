<?php /** @var \App\User $user */?>
@extends('layouts.front', [
    'title' => __('users/profile.title', ['name' => $user->name]),
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('users/profile.description') }}" />
    <meta property="og:url" content="{{ route('users.profile', $user) }}" />
    @if ($user->avatar)<meta property="og:image" content="{{ $user->getAvatarUrl()  }}" />@endif
@endsection

@section('content')
    <header class="masthead reduced-masthead" id="about">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{!! $user->name !!}</h1>
                        <p class="mb-5">{{ __('users/profile.fields.member_since', ['date' => $user->created_at->diffForHumans()]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="team" id="profile">
        <div class="container">
            <div class="section-body">

                <div class="row">
                    <div class="col-9">
                        @if (!empty($campaigns))
                            <h1>{{ __('users/profile.fields.public_campaigns') }}</h1>

                            <div class="row">
                                @foreach ($campaigns as $campaign)
                                    <div class="col-lg-4 col-md-6">
                                        @include('front._campaign', ['campaign' => $campaign, 'featured' => false])
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-3">

                        <div class="card">
                            <div class="card-body">
                                @if ($user->subscribed('kanka'))
                                @if ($user->isElementalPatreon())
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png);"></div>
                                @elseif ($user->isWyvern())
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/wyvern-325.png);"></div>
                                @elseif ($user->isOwlbear())
                                <div class="card-image" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png);"></div>
                                @endif
                                <h5 class="card-title text-muted text-uppercase text-center">
                                    {{ $user->patreon_pledge }}
                                </h5>
                                @endif

                                <div class="text-center">
                                    <p>
                                        {{ __('users/profile.fields.member_since', ['date' => $user->created_at->format('M d, Y')]) }}
                                    </p>

                                    @if ($user->subscribed('kanka'))
                                        <p>
                                            {{ __('users/profile.fields.subscriber_since', ['date' => $user->subscription('kanka')->created_at->format('M d, Y')]) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h4>{{ __('') }}</h4>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
