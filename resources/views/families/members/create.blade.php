@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('families.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($model->entity)->list(),
        Breadcrumb::show()
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['families.members.store', $campaign, $model->id]">
        @include('partials.forms._dialog', [
            'title' => __('families.members.create.title', ['name' => $model->name]),
            'content' => 'families.members._form',
            'submit' => __('organisations.members.actions.add_multiple'),
        ])
    </x-form>
@endsection
