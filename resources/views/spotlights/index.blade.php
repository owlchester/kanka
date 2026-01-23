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
                        {{ __('spotlights.rules') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-5 max-w-7xl mx-auto text-dark">
        <div class="flex flex-col gap-10">
            <p class="text-purple text-md">{{ __('spotlights.started') }}</p>

            <div class="flex flex-wrap gap-8">
                <?php /** @var \App\Models\Campaign $campaign */?>
                @foreach ($campaigns as $campaign)
                    <a
                        href="{{ route('spotlights.form', $campaign) }}"
                        class="flex flex-col gap-5 text-left w-72"
                        title="{!! $campaign->name !!}"
                    >
                        <img src="{{ $campaign->image ? $campaign->thumbnail(320, 240) : 'https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg' }}" alt="{{ $campaign->name }}" class="w-80 h-60">

                        <div class="flex flex-col gap-2">
                            <div class="flex gap-2">
                                <h3 class="text-md truncate">{!! $campaign->name !!}</h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
