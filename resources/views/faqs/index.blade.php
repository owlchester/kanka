<?php use Illuminate\Support\Str ?>
@extends('layouts.front', [
    'title' => trans('front.menu.faq'),
    'menus' => [
        'faq',
    ],
])
<?php /** @var \App\Models\Faq $faq */ ?>
@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.faq.title') }}</h1>
                        <p class="mb-5">{{ trans('front.faq.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="faq">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'free', 'slug' => Str::slug(__('faq.free.question'))]) }}">{{ __('faq.free.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.free.answer', [
                            'patreon' => link_to(config('patreon.url'), 'Patreon', ['target' => '_blank']),
                        ])) !!}</p>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'multiworld', 'slug' => Str::slug(__('faq.multiworld.question'))]) }}">{{ __('faq.multiworld.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.multiworld.answer')) !!}</p>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'visibility', 'slug' => Str::slug(__('faq.visibility.question'))]) }}">{{ __('faq.visibility.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.visibility.answer')) !!}</p>
                        <hr>


                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'map', 'slug' => Str::slug(__('faq.map.question'))]) }}">{{ __('faq.map.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.map.answer')) !!}</p>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'conversations', 'slug' => Str::slug(__('faq.conversations.question'))]) }}">{{ __('faq.conversations.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.conversations.answer')) !!}</p>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'entity-notes', 'slug' => Str::slug(__('faq.entity-notes.question'))]) }}">{{ __('faq.entity-notes.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.entity-notes.answer')) !!}</p>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'help', 'slug' => Str::slug(__('faq.help.question'))]) }}">{{ __('faq.help.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.help.answer', [
                            'discord' => link_to(config('discord.url'), 'Discord', ['target' => '_blank'])
                        ])) !!}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'permissions', 'slug' => Str::slug(__('faq.permissions.question'))]) }}">{{ __('faq.permissions.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.permissions.answer')) !!}</p>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/ikNPzNgjYmg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'attribute-templates', 'slug' => Str::slug(__('faq.attribute-templates.question'))]) }}">{{ __('faq.attribute-templates.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.attribute-templates.answer')) !!}</p>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/qKnTpuePqUA" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'mobile', 'slug' => Str::slug(__('faq.mobile.question'))]) }}">{{ __('faq.mobile.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.mobile.answer')) !!}</p>
                        <hr>

                        <h4>
                            <a href="{{ route('faq.show', ['key' => 'plans', 'slug' => Str::slug(__('faq.plans.question'))]) }}">{{ __('faq.plans.question') }}</a>
                        </h4>
                        <p class="text-muted">{!! nl2br(__('faq.plans.answer')) !!}</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection