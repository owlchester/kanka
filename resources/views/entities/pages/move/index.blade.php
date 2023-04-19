@extends('layouts.app', [
    'title' => __('entities/move.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        __('crud.actions.move'),
    ]
])

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['entities.move', $entity->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
    <div class="max-w-3xl">
        <x-box>
            <p class="help-block mb-5">
                {{ __('entities/move.panel.description') }}
            </p>

            <div class="form-group">
                <label>{{ __('entities/move.fields.campaign') }}</label>
                {!! Form::select('campaign', $campaigns, null, ['class' => 'form-control']) !!}
            </div>

            @can('update', $entity->child)
                <div class="form-group form-check">
                    <label>{!! Form::checkbox('copy', 1, true) !!}
                        {{ __('entities/move.fields.copy') }}
                    </label>
                    <p class="help-block">
                        {{ __('entities/move.helpers.copy') }}
                    </p>
                </div>
            @else
                {!! Form::hidden('copy', 1) !!}
            @endcan

            @includeIf($entity->pluralType() . '.bulk.modals._copy_to_campaign')

            <div class="flex items-center">
                <div class="grow">
                    @includeWhen(!request()->ajax(), 'partials.footer_cancel')
                </div>
                <button class="btn btn-success">
                    <i class="fa-solid fa-copy" aria-hidden="true"></i>
                    @can('update', $entity->child) {{ __('entities/move.actions.move') }} @else  {{ __('entities/move.actions.copy') }} @endcan
                </button>
            </div>
        </x-box>
    </div>

    {!! Form::close() !!}
@endsection
