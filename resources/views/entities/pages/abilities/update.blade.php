@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', $entity->id), 'label' => trans('crud.tabs.abilities')],
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('entities/abilities.update.title', ['name' => $entity->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($ability, ['route' => ['entities.entity_abilities.update', $entity->id, $ability], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

            <div class="form-group">
                <label>{{ __('crud.fields.ability') }}</label>
                {!! $ability->ability->tooltipedLink() !!}
                {!! Form::hidden('ability_id', $ability->ability_id) !!}
            </div>

            <div class="form-group">
                <label>{{ __('entities/abilities.fields.position') }}</label>
                {!! Form::number('position', null, ['class' => 'form-control', 'min' => 0, 'max' => '100']) !!}
            </div>

            <div class="form-group">
                <label>{{ __('entities/abilities.fields.note') }}</label>
                {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4]) !!}
            </div>

            @include('cruds.fields.visibility')

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!request()->ajax())
                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
