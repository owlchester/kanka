@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.relations.index', $entity->id), 'label' => trans('crud.tabs.relations')],
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('entities/relations.update.title', ['name' => $entity->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($relation, ['route' => ['entities.relations.update', $entity->id, $relation], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}
            @include('entities.pages.relations._form')

            {!! Form::hidden('owner_id', $entity->id) !!}

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            @if(!empty($from))
                <input type="hidden" name="from" value="{{ $from }}" />
            @endif

            {!! Form::close() !!}
        </div>
    </div>
@endsection
