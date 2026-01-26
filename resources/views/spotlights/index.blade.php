<?php /** @var \App\Models\Campaign? $campaign */?>
@extends('layouts.front', [
    'title' => __('spotlights.title'),
    'skipPerf' => true,
])

@section('content')

    <section class="bg-purple text-white gap-16">
        <div class="px-6 py-20 lg:max-w-7xl mx-auto flex flex-col gap-8">
            <div class="flex gap-10">
                <div class="grow flex flex-col gap-3 max-w-2xl">
                    <h1 class="">{{ __('spotlights.title') }}</h1>

                    <p class="text-light">
                        {!! __('spotlights.rules', [
    'showcase' => '<a href="' . Domain::toFront('showcase') . '" class="font-semibold text-light">' . __('footer.showcase') . '</a>'
]) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-5 max-w-7xl mx-auto text-dark">
        <div class="flex flex-col gap-10">
            @if (!empty($campaign))
                @if ($campaign->isPublic())
                    <div class="flex gap-5">
                        <a href="{{ route('spotlights.form', $campaign) }}" class="btn-round">
                            {!! __('spotlights.overview.cta', ['name' => $campaign->name]) !!}
                        </a>
                        <a href="{{ \App\Facades\Domain::toFront('showcase') }}" class="btn-round">
                            {!! __('spotlights.overview.showcase') !!}
                        </a>
                    </div>
                @else
                    <p>
                        {!! __('spotlights.overview.campaign-not-public', ['name' => $campaign->name]) !!}
                    </p>
                @endif
            @else
                <p class="text-purple text-md">{{ __('spotlights.started') }}</p>

                <div class="flex flex-wrap gap-8">
                    <?php /** @var \App\Models\Campaign $world */?>
                    @foreach ($campaigns as $world)
                        <a
                            href="{{ route('spotlights.form', $world) }}"
                            class="flex flex-col gap-5 text-left w-72"
                            title="{!! $world->name !!}"
                        >
                            <img src="{{ $world->image ? $world->thumbnail(320, 240) : 'https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg' }}" alt="{{ $world->name }}" class="w-80 h-60">

                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <h3 class="text-md truncate">{!! $world->name !!}</h3>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif
        </div>
    </section>

    <section class="p-5 max-w-7xl mx-auto text-dark" id="faq">
        <div class="flex flex-col gap-10">
            <div class="flex flex-col gap-2">
                <span class="block text-md font-bold">
                    {{ __('spotlights.faq.what.q') }}
                </span>
                <p>
                    {{ __('spotlights.faq.what.a') }}
                </p>
            </div>
            <div class="flex flex-col gap-2">
                <span class="block text-md font-bold">
                    {{ __('spotlights.faq.who.q') }}
                </span>
                <p>
                    {{ __('spotlights.faq.who.a.lead') }}
                </p>
                <p>
                    {{ __('spotlights.faq.who.a.requirements') }}
                </p>
                <ul class="mx-5 list-disc">
                    <li> {{ __('spotlights.faq.who.a.req1') }}</li>
                    <li> {{ __('spotlights.faq.who.a.req2') }}</li>
                    <li> {{ __('spotlights.faq.who.a.req3') }}</li>
                </ul>
            </div>
            <div class="flex flex-col gap-2">
                <span class="block text-md font-bold">
                    {{ __('spotlights.faq.how.q') }}
                </span>
                <p>
                    {{ __('spotlights.faq.how.a.lead') }}
                </p>
                <p>
                    {{ __('spotlights.faq.how.a.requirements') }}
                </p>
                <ul class="mx-5 list-disc">
                    <li> {{ __('spotlights.faq.how.a.req1') }}</li>
                    <li> {{ __('spotlights.faq.how.a.req2') }}</li>
                    <li> {{ __('spotlights.faq.how.a.req3') }}</li>
                </ul>
            </div>
            <div class="flex flex-col gap-2">
                <span class="block text-md font-bold">
                    {{ __('spotlights.faq.selected.q') }}
                </span>
                <p>
                    {{ __('spotlights.faq.selected.a.lead') }}
                </p>
                <ul class="mx-5 list-disc">
                    <li>{{ __('spotlights.faq.selected.a.req1') }}</li>
                    <li>{!! __('spotlights.faq.selected.a.req2', [
    'blog' => '<a class="text-blue font-medium" href="https://blog.kanka.io">Blog</a>',
    'showcase' => '<a class="text-blue font-medium" href="' . \App\Facades\Domain::toFront('showcase') . '">' . __('footer.showcase') . '</a>'
]) !!}</li>
                    <li>{{ __('spotlights.faq.selected.a.req3') }}</li>
                </ul>
                <p>
                    {{ __('spotlights.faq.selected.a.end') }}
                </p>
            </div>

            <div class="flex flex-col gap-2">
                <span class="block text-md font-bold">
                    {{ __('spotlights.faq.reapply.q') }}
                </span>
                <p>
                    {{ __('spotlights.faq.reapply.a') }}
                </p>
            </div>

            <p class="text-purple text-sm">
            {{ __('spotlights.faq.finisher') }}
            </p>
        </div>
    </section>

@endsection
