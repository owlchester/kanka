@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        __('crud.actions.transform'),
    ]
])

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['entities.transform', $entity->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-lg-8">
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
                        <button class="btn btn-success">{{ __('entities/transform.actions.transform') }}</button>
                        @includeWhen(!request()->ajax(), 'partials.or_cancel')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
