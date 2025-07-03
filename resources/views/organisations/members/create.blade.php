@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.create.title_multiple', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($model->entity)->list(),
        Breadcrumb::show()
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['organisations.organisation_members.store', $campaign, $model->id]">
        @include('partials.forms._dialog', [
            'title' => __('organisations.members.create.title_multiple', ['name' => $model->name]),
            'content' => 'organisations.members._form',
            'submit' => __('organisations.members.actions.add_multiple'),
        ])
    </x-form>
@endsection
