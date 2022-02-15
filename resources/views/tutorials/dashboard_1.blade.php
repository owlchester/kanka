@extends('tutorials.content')

@section('title')
    {{ __('tutorials/home.dashboard_1.title') }}
@endsection

@section('body')
    <p>{{ __('tutorials/home.dashboard_1.first') }}</p>
    <p>{{ __('tutorials/home.dashboard_1.second') }}</p>
    <p>{{ __('tutorials/home.dashboard_1.third') }}</p>
@endsection

@section('footer')
    <button class="btn btn-warning pull-left" data-tutorial="disable" data-url="{{ route('settings.tutorial.disable') }}">
        {{ __('tutorials/actions.disable') }}
    </button>
    <button class="btn btn-default" data-tutorial="close">
        {{ __('tutorials/actions.close') }}
    </button>
@endsection
