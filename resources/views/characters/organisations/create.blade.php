@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('characters.organisations.create.title'),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
        \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['characters.character_organisations.store', $campaign, $model->id]">
        @include('partials.forms.form', [
            'title' => __('characters.organisations.create.title'),
            'content' => 'characters.organisations._form',
            'submit' => __('crud.add'),
            'dialog' => true,
            'dropdownParent' => '#primary-dialog',
        ])

        <input type="hidden" name="character_id" value="{{ $model->id }}" />
    </x-form>
@endsection
