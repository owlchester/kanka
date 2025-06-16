@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.transfer.posts.title'),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($tag->entity)->list(),
        Breadcrumb::show(),
        __('tags.transfer.transfer'),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['tags.transfer.posts-process', $campaign, $tag->id]">
        @include('partials.forms._dialog', [
            'title' => __('tags.transfer.posts.title'),
            'content' => 'tags.transfer.posts.form',
            'submit' =>  __('tags.transfer.transfer'),
        ])
    </x-form>
@endsection
