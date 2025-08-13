@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-form :action="['settings.api.store']">
        @include('partials.forms.form', [
            'title' => __('settings/api.tokens.new'),
            'content' => 'settings.api._form',
            'submit' => __('crud.save'),
        ])
    </x-form>
@endsection
