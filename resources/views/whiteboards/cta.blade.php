<?php /** @var \App\Models\Whiteboard $whiteboard */ ?>
@extends('layouts.app', [
    'title' => __('entities.whiteboards'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('content')
    <x-grid type="1/1">
        <h1 class="">{{ __('whiteboards.cta.title') }}</h1>

        <p class="max-w-2xl">
            {{ __('whiteboards.cta.text') }}
        </p>

        <x-premium-cta-footer :campaign="$campaign" />
    </x-grid>

@endsection
