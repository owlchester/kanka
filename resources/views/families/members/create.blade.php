@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('families.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model)
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['families.members.store', $campaign, $model->id]">
    @include('partials.forms._dialog', [
        'title' => __('families.members.create.title', ['name' => $model->name]),
        'content' => 'families.members._form',
        'submit' => __('families.members.create.submit'),
    ])
    <input type="hidden" name="family_id" value="{{ $model->id }}" />
    </x-form>
@endsection
