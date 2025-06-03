@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('posts.move.title'),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.actions.move'),
    ],
    'entity' => null,
])

@section('content')
    @include('partials.errors')
    <x-form :action="['posts.move-process', $campaign, $entity->id, $post->id]">
        @include('partials.forms._dialog', [
            'title' => __('posts.move.title'),
            'content' => 'entities.pages.posts.move.form',
            'submit' => auth()->check() && auth()->user()->can('update', $entity) ? __('entities/move.actions.move') : __('entities/move.actions.copy'),
        ])
    </x-form>
@endsection
