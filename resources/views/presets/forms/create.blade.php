@extends('layouts.app', [
    'title' => __('presets.create.title'),
    'centered' => true,
])


@section('content')

    <form method="POST" action="{{ route('presets.store', [$campaign, $presetType]) }}">
        @include('partials.forms._panel', [
           'title' => __('presets.create.title'),
           'content' => 'presets.forms._' . $presetType->code,
        ])
        <input type="hidden" name="from" value="{{ $from }}" />
        @csrf
    </form>

@endsection
