@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-form :action="['settings.client.store']">
        @include('partials.forms.form', [
            'title' => 'Create Client',
            'content' => 'settings.client._form',
            'submit' => 'Create',
        ])
    </x-form>
@endsection
