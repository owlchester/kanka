@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('posts.visibility.title'),
    'breadcrumbs' => [
    ]
])

@section('content')
    <x-form :action="['posts.update.visibility', $campaign, $entity, $post]" class="post-visibility" direct>
        @include('partials.forms.form', [
            'title' => __('posts.visibility.title'),
            'content' => 'entities.pages.posts.dialogs._visibility',
            'model' => $post
        ])
    </x-form>
@endsection
