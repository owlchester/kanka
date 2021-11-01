@extends('layouts.app', [
    'title' => __('entities/move.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        __('crud.actions.move'),
    ]
])

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['entities.move', $entity->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-10 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ __('entities/move.panel.title') }}</h4>
                </div>
                <div class="panel-body">
                    <p class="help-block">
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
                        </div>
                    @else
                        {!! Form::hidden('copy', 1) !!}
                    @endcan

                    @includeIf($entity->pluralType() . '.bulk.modals._copy_to_campaign')

                    <div class="form-group">
                        <button class="btn btn-success">@can('update', $entity->child) {{ __('entities/move.actions.move') }} @else  {{ __('entities/move.actions.copy') }} @endcan</button>
                        @include('partials.or_cancel')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
