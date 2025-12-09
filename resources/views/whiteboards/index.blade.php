<?php /** @var \App\Models\Whiteboard $whiteboard */ ?>
@extends('layouts.app', [
    'title' => __('entities.whiteboards'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('content')

    <div class="flex gap-2 justify-between items-center">
        <h3 class="text-xl">{{ __('entities.whiteboards') }}</h3>
        <a href="{{ route('whiteboards.create', $campaign) }}" class="btn2 btn-primary">
            <x-icon class="plus" />
            {{ __('entities.whiteboard') }}
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:flex flex-wrap gap-4 w-full">
        @foreach ($models as $whiteboard)
            <a href="{{ route('whiteboards.show', [$campaign, $whiteboard]) }}" class="rounded-xl hover:shadow-md bg-base-100 xl:w-80 overflow-hidden flex flex-col">
                <div class="bg-base-200 w-full h-40"></div>
                <div class="flex gap-1 p-4 ">
                    <div class="flex flex-col gap-1">
                        <span class="whiteboard-name text-md">
                            {!! $whiteboard->name !!}
                        </span>
                        <span class="whiteboard-timestamp text-neutral-content text-xs" title="{{ $whiteboard->created_at }}">
                            {{ __('crud.timestamps.edited', ['ago' => $whiteboard->created_at->diffForHumans()]) }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {!! $models->links() !!}
@endsection
