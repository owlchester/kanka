<?php /** @var \App\User $user */?>
@extends('layouts.front', [
    'title' => __('roadmap/index.title'),
    'skipPerf' => true,
])


@section('content')

    <section class="bg-purple text-white gap-16">
        <div class="px-6 py-20 lg:max-w-7xl mx-auto flex flex-col gap-8">
            <div class="flex gap-10">
                <div class="grow flex flex-col gap-3 max-w-2xl">
                    <h1 class="">Public roadmap</h1>

                    <p class="text-light">Welcome to Kanka's public roadmap, where you'll find features we are working on and upvote on features that you want to see added to Kanka.</p>

                    <a href="https://docs.kanka.io/en/latest/guides/roadmap" class="text-white underline">Learn more about the roadmap</a>
                </div>
            </div>
        </div>
    </section>
    <section class="p-5">
        <h2 class="">In Progress</h2>

        <div class="flex flex-col gap-10">
        @php /** @var \App\Models\FeatureCategory $category **/ @endphp
        @foreach ($categories as $category)
            @if ($category->nothingPlanned())
                @continue
            @endif
            <div class="rounded-2xl bg-gray-200 overflow-hidden">
                <h3 class="bg-purple text-white p-5">{{ $category->name }}</h3>
                <div class="p-5 grid grid-cols-1 xl:grid-cols-4 gap-5">
                    <div class="border-r xl:col-span-2">
                        <h4 class="mb-5">Now</h4>
                        <div class="grid xl:grid-cols-2 gap-5">
                        @foreach ($category->now as $feature)
                            @include('roadmap.feature._progress', $feature)
                        @endforeach
                        </div>
                    </div>
                    <div class="border-r">
                        <h4 class="mb-5">Next</h4>
                        <div class="flex flex-col gap-5">
                        @foreach ($category->next as $feature)
                            @include('roadmap.feature._progress', $feature)
                        @endforeach
                        </div>
                    </div>
                    <div class="">
                        <h4 class="mb-5">Later</h4>
                        <div class="flex flex-col gap-5">
                        @foreach ($category->later as $feature)
                            @include('roadmap.feature._progress', $feature)
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </section>

    <section class="p-5" id="ideas">
        <h2 class="">Ideas</h2>
        <div class="grid xl:grid-cols-4 gap-5">
            <div class="xl:col-span-3 flex flex-col gap-5">
                @foreach ($ideas as $feature)
                    @include('roadmap.feature._idea', $feature)
                @endforeach
            </div>

            @auth()
                @include('roadmap.feature._form')
            @else
                <div class="bg-purple text-white rounded-2xl p-5 flex flex-col gap-5">
                    <h2>Share your ideas</h2>
                    <p class="text-light">Have an idea to improve Kanka? Share it with our development team.</p>

                    <a href="{{ route('login') }}" class="btn-round rounded-full">Log in</a>
                </div>
            @endauth

        </div>
    </section>
@endsection

@section('modals')
    <x-dialog id="feature-dialog" :loading="true" />
@endsection

