@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.transfer.entities.title'),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($tag->entity)->list(),
        Breadcrumb::show(),
        __('tags.transfer.transfer'),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['tags.transfer-process', $campaign, $tag->id]">
        @include('partials.forms._dialog', [
            'title' => __('tags.transfer.entities.title'),
            'content' => 'tags.transfer.entities.form',
            'submit' =>  __('tags.transfer.transfer'),
        ])
    </x-form>
@endsection
