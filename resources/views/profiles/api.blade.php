@extends('layouts.app', [
    'title' => trans('profiles.title'),
    'description' => trans('profiles.description'),
    'breadcrumbs' => [
        trans('profiles.title'),
        trans('crud.edit'),
    ]
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">

            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>

@endsection