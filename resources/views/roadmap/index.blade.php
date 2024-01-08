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
        <h1 class="">In Progress</h1>

        <div class="flex flex-col gap-5">
        @php /** @var \App\Models\FeatureCategory $category **/ @endphp
        @foreach ($categories as $category)
            <div class="rounded-2xl bg-gray-200 overflow-hidden">
                <h2 class="bg-purple text-white text-xl p-5">{{ $category->name }}</h2>
                <div class=" p-5 grid grid-cols-4 gap-2">
                    <div class="border-r col-span-2">
                        <p class="text-md">Now</p>
                        @foreach ($category->now() as $feature)
                            @include('roadmap._progress', $feature)
                        @endforeach
                    </div>
                    <div class="border-r">
                        <p class="text-md">Next</p>
                        @foreach ($category->next() as $feature)
                            @include('roadmap._progress', $feature)
                        @endforeach
                    </div>
                    <div class="">
                        <p class="text-md">Later</p>
                        @foreach ($category->later() as $feature)
                            @include('roadmap._progress', $feature)
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </section>

    <section class="p-5" id="ideas">
        <h1 class="">Ideas</h1>
        <div class="grid grid-cols-4 gap-5">
            <div class="col-span-3 flex flex-col gap-5">
                @foreach ($ideas as $feature)
                    @include('roadmap._idea', $feature)
                @endforeach
            </div>

            <form method="POST" action="{{ route('roadmap.store') }}">
                {{ csrf_field() }}
            <div class="bg-purple text-white rounded-2xl p-5 flex flex-col gap-5">
                <h2>Share your ideas</h2>
                <p class="text-light">Have an idea to improve Kanka? Share it with our development team.</p>

                <div class="field field-name">
                    <label>One sentence that summarises your idea</label>
                    <input type="text" maxlength="90" class="rounded text-dark  w-full p-2" name="name" />
                </div>

                <div class="field field-description">
                    <label>Why your idea is useful, who should benefit and how should it work?</label>
                    <textarea name="description" class="rounded text-dark w-full p-2" rows="5"></textarea>
                </div>

                <p class="text-light">Once reviewed, your idea will show up in the ideas section. If we have questions, we'll contact you on the <a href="https://kanka.io/go/discord">Discord</a>.</p>

                <input type="submit" value="Submit idea" class="btn-round rounded-full" />
            </div>
            </form>

        </div>
    </section>
@endsection

