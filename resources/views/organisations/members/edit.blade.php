@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($model->entity)->list(),
        Breadcrumb::show()
    ]
])
@section('content')
    <x-form :action="['organisations.organisation_members.update', $campaign, $model->id, $member->id]" method="PATCH">
        @include('partials.forms._dialog', [
            'title' => __('organisations.members.edit.title', ['name' => $model->name]),
            'content' => 'organisations.members._form',
        ])
        <input type="hidden" name="organisation_id" value="{{ $model->id }}" />
    </x-form>
@endsection
