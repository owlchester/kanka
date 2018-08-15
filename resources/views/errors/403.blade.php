@extends('errors::layout')

@section('title', trans('errors.403.title'))

@section('message')

    <p>{{ trans('errors.403.body') }}</p>

    <p>{!! trans('errors.footer', ['discord' => link_to("https://discord.gg/rhsyZJ4", 'Discord')]) !!}</p>

@endsection
