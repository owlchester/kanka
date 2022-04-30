@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', $entity->id), 'label' => trans('crud.tabs.abilities')],
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    {!! Form::model($ability, [
        'route' => ['entities.entity_abilities.update', $entity->id, $ability],
        'method' => 'PATCH',
        'data-shortcut' => 1
    ]) !!}
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

            <div class="form-group">
                <label>{{ __('crud.fields.ability') }}</label><br />
                {!! $ability->ability->tooltipedLink() !!}
                {!! Form::hidden('ability_id', $ability->ability_id) !!}
            </div>

            <div class="form-group">
                <label>{{ __('entities/abilities.fields.position') }}</label>
                {!! Form::number('position', null, ['class' => 'form-control', 'min' => 0, 'max' => '100']) !!}
            </div>

            <div class="form-group">
                <div class="pull-right hidden-xs">
                    <i class="fa-solid fa-question-circle" title="{!! __('entities/abilities.helpers.note', [
    'code' => '<code>[character:4096]</code>',
    'attr' => '<code>{Strengh}</code>'
]) !!}" data-toggle="tooltip" data-html="true" data-placement="left"></i>
                </div>
                <label>{{ __('entities/abilities.fields.note') }}</label>
                {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4]) !!}
                <p class="help-block hidden-sm hidden-md hidden-lg hidden-xl">{!! __('entities/abilities.helpers.note', [
    'code' => '<code>[character:4096]</code>',
    'attr' => '<code>{Strengh}</code>'
]) !!}</p>
            </div>

            @include('cruds.fields.visibility')
        </div>
        <div class="panel-footer">
            <button class="btn btn-success pull-right">{{ __('crud.save') }}</button>
            @include('partials.footer_cancel')
        </div>
    </div>
    {!! Form::close() !!}
@endsection
