<?php use Illuminate\Support\Str ?>
@extends('layouts.front', [
    'title' => __('front.menu.faq'),
    'menus' => [
        'faq',
    ],
])

@section('og')
    <meta property="og:description" content="{{ __("front.faq.description") }}" />
    <meta property="og:url" content="{{ route('faq.index') }}" />
@endsection

<?php /** @var \App\Models\Faq $faq */ ?>
@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front.faq.title') }}</h1>
                        <p class="mb-5">{{ __('front.faq.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="faqs" id="faq">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-4">
                        <h2>{{ __('faq.sections.general') }}</h2>
                        <ul>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'multiworld', 'slug' => Str::slug(__('faq.multiworld.question'))]) }}">
                                    {{ __('faq.multiworld.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'campaign-sync', 'slug' => Str::slug(__('faq.campaign-sync.question'))]) }}">
                                    {{ __('faq.campaign-sync.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'account-deletion', 'slug' => Str::slug(__('faq.account-deletion.question'))]) }}">
                                    {{ __('faq.account-deletion.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'help', 'slug' => Str::slug(__('faq.help.question'))]) }}">
                                    {{ __('faq.help.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'public-campaigns', 'slug' => Str::slug(__('faq.public-campaigns.question'))]) }}">
                                    {{ __('faq.public-campaigns.question') }}
                                </a>
                            </li>
                        </ul>

                    </div>
                    <div class="col-md-4">
                        <h2>{{ __('faq.sections.other') }}</h2>
                        <ul>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'mobile', 'slug' => Str::slug(__('faq.mobile.question'))]) }}">
                                    {{ __('faq.mobile.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'plans', 'slug' => Str::slug(__('faq.plans.question'))]) }}">
                                    {{ __('faq.plans.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'app_backup', 'slug' => Str::slug(__('faq.app_backup.question'))]) }}">
                                    {{ __('faq.app_backup.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'bugs', 'slug' => Str::slug(__('faq.bugs.question'))]) }}">
                                    {{ __('faq.bugs.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'discord', 'slug' => Str::slug(__('faq.discord.question'))]) }}">
                                    {{ __('faq.discord.question') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h2>{{ __('faq.sections.pricing') }}</h2>
                        <ul>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'free', 'slug' => Str::slug(__('faq.free.question'))]) }}">
                                    {{ __('faq.free.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'early-access', 'slug' => Str::slug(__('faq.early-access.question'))]) }}">
                                    {{ __('faq.early-access.question') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq.show', ['key' => 'unboost', 'slug' => Str::slug(__('faq.unboost.question'))]) }}">
                                    {{ __('faq.unboost.question') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr />

                <h2 class="mt-5 text-center">{{ __('front.faq.kb.title') }}</h2>
                <p class="text-center">{{ __('front.faq.kb.text') }}</p>
                <div class="text-center">
                    <a href="{{ route('front.faqs.index') }}" class="btn btn-light">
                        {{ __('front.faq.kb.button') }}
                    </a>
                </div>


                <h2 class="mt-5 text-center">{{ __('front.faq.helpers.more') }}</h2>
                <div class="text-center faq-more">
                    <a href="{{ config('social.discord') }}" class="btn btn-light">
                        <i class="fab fa-discord"></i>
                        {{ __('front.help.discord') }}
                    </a>
                    <a href="{{ config('social.facebook') }}" class="btn btn-light">
                        <i class="fab fa-facebook"></i>
                        {{ __('front.help.facebook') }}
                    </a>
                    <a href="mailto:hello@kanka.io" class="btn btn-light">
                        <i class="fa fa-envelope-open"></i>
                        {{ __('front.help.email') }}
                    </a>
            </div>
        </div>
    </section>
@endsection
