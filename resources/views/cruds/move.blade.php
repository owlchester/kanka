@extends('layouts.app', [
    'title' => trans('crud.move.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        trans('crud.actions.move'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')
            {!! Form::open(['route' => ['entities.move', $entity->id], 'method' => 'POST']) !!}

            {{ csrf_field() }}
            <div class="row">
                @can('move', $entity->child)
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ trans('crud.move.panels.change') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{ trans('crud.move.fields.target') }}</label>
                                {!! Form::select('target', $entities, null, ['class' => 'form-control']) !!}
                                <p class="help-block">{{ trans('crud.move.hints.target') }}</p>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endcan


                @if (Auth::user()->hasOtherCampaigns($entity->campaign_id))
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">{{ trans('crud.move.panels.move') }}</h4>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label>{{ trans('crud.move.fields.campaign') }}</label>
                                    {!! Form::select('campaign', Auth::user()->moveCampaignList(), null, ['class' => 'form-control']) !!}
                                    <p class="help-block">{{ trans('crud.move.hints.campaign') }}</p>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success">{{ trans('crud.save') }}</button>
                                    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>


            {!! Form::close() !!}
        </div>
    </div>
@endsection
