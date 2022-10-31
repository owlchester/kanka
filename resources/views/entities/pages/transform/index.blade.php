@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        __('crud.actions.transform'),
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['entities.transform', $entity->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">{{ __('entities/transform.panel.title') }}</h4>
        </div>
        <div class="panel-body">
            <p class="help-block">
                {{ __('entities/transform.panel.description') }}
            </p>
            <div class="form-group">
                <label>{{ __('entities/transform.fields.target') }}</label>
                {!! Form::select('target', $entities, null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
            </div>
        </div>
        <div class="panel-footer">
            @includeWhen(!request()->ajax(), 'partials.footer_cancel')
            <button class="btn btn-success pull-right">
                <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
                {{ __('entities/transform.actions.transform') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
