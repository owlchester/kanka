@extends('layouts.app', [
    'title' => __('entities/move.title', ['name' => $post->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.actions.move'),
    ]
])

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['posts.move', $campaign, $entity->id, $post->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
    <x-box>
        <div class="field-entity mb-5">
            <label>{{ __('entities/notes.move.entity') }}</label>
            <select name="entity" class="form-control select2" data-tags="true" data-url="{{ route('search.entities-with-relations', $campaign) }}" data-allow-clear="false" data-allow-new="false" data-placeholder="{{ __('entities/notes.move.description') }}"></select>
        </div>
        <div class="field-copy form-check">
            <label>{!! Form::checkbox('copy', 1, true) !!}
                {{ __('entities/notes.move.copy') }}
            </label>
        </div>

        <x-dialog.footer>
            <button class="btn2 btn-primary">@can('update', $entity->child) {{ __('entities/move.actions.move') }} @else  {{ __('entities/move.actions.copy') }} @endcan</button>
        </x-dialog.footer>
    </x-box>

    {!! Form::close() !!}
@endsection
