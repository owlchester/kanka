@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-form :action="['settings.api.store']">
        @include('partials.forms.form', [
            'title' => 'Create Token',
            'content' => 'settings.api._form',
            'submit' => 'Create',
        ])
    </x-form>
@endsection
