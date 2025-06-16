@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('races.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($model->entity)->list(),
        Breadcrumb::show(),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['races.members.store', $campaign, $model->id]">
        @include('partials.forms._dialog', [
            'title' => __('races.members.create.title', ['name' => $model->name]),
            'content' => 'races.members._form',
            'submit' => __('races.members.create.submit'),
        ])
        <input type="hidden" name="race_id" value="{{ $model->id }}" />
    </x-form>
@endsection
