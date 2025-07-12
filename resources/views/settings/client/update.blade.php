@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-form :action="['settings.client.update', $client]" method="PUT">
        @include('partials.forms.form', [
            'title' => 'Update Client',
            'content' => 'settings.client._form',
            'submit' => 'Update',
        ])
    </x-form>
@endsection
