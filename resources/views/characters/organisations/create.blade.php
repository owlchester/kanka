@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('characters.organisations.create.title'),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($model->entity)->list(),
        Breadcrumb::show(),
        \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['characters.character_organisations.store', $campaign, $model->id]">
        @include('partials.forms._dialog', [
            'title' => __('characters.organisations.create.title'),
            'content' => 'characters.organisations._form',
            'submit' => __('crud.add'),
            'dropdownParent' => '#primary-dialog',
        ])
    </x-form>
@endsection
