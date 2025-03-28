@extends('layouts.ajax', [
    'title' => __('conversations.participants.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('conversations.index', $campaign), 'label' => __('entities.conversations')],
        ['url' => route('conversations.show', [$campaign, $model->id]), 'label' => $model->name],
        __('crud.update'),
    ],
    'centered' => true,
])

@section('content')
    @include('partials.forms._dialog', [
        'title' => __('conversations.participants.modal', ['name' => $model->name]),
        'content' => 'conversations.participants._form',
        'actions' => 'conversations.participants._actions',
        'skipCancel' => true,
    ])
@endsection
