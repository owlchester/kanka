@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model)
    ]
])
@section('content')
    <x-form :action="['organisations.organisation_members.update', $campaign, $model->id, $member->id]" method="PATCH">
        @include('partials.forms.form', [
            'title' => __('organisations.members.edit.title', ['name' => $model->name]),
            'content' => 'organisations.members._form',
            'dialog' => true,
        ])
        <input type="hidden" name="organisation_id" value="{{ $model->id }}" />
    </x-form>
@endsection
