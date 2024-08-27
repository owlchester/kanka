<?php /** @var \App\Models\User $user */?>
@extends('layouts.front', [
    'title' => __('footer.roadmap'),
    'skipPerf' => true,
])


@section('content')

    <section class="bg-purple text-white gap-16">
        <div class="px-6 py-20 lg:max-w-7xl mx-auto flex flex-col gap-8">
            <div class="flex gap-10">
                <div class="grow flex flex-col gap-3 max-w-2xl">
                    <h1 class="">Public roadmap</h1>

                    <p class="text-light">Welcome to Kanka's public roadmap, where you'll find features we are working on and upvote on features that you want to see added to Kanka.</p>

                    <p>
                    <a href="https://docs.kanka.io/en/latest/guides/roadmap.html" class="text-white underline">Learn more about the roadmap</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-5 max-w-7xl mx-auto">
        @livewire('roadmap')
    </section>
@endsection

@section('modals')
    <x-dialog id="feature-dialog" :loading="true" />
@endsection

