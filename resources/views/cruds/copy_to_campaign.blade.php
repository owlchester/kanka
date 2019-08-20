@extends('layouts.app', [
    'title' => trans('crud.copy_to_campaign.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        trans('crud.actions.copy_to_campaign'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')
            {!! Form::open(['route' => ['entities.copy_to_campaign', $entity->id], 'method' => 'POST']) !!}

            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>{{ trans('crud.copy_to_campaign.panel') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{ trans('crud.move.fields.campaign') }}</label>
                                {!! Form::select('campaign', $campaigns, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
