@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.transfer.title', ['name' => $tag->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($tag->entity)->list(),
        Breadcrumb::show($tag),
        __('tags.transfer.transfer'),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['tags.transfer.posts-process', $campaign, $tag->id]">
        @include('partials.forms._dialog', [
            'title' => __('tags.transfer.transfer'),
            'content' => 'tags.transfer._post_form',
            'submit' =>  __('tags.transfer.transfer'),
        ])
    </x-form>
@endsection
