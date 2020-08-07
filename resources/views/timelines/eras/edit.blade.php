<?php /**
 * @var \App\Models\Timeline $timeline
 * @var \App\Models\TimelineEra $model
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('timelines.index'), 'label' => __('timelines.index.title')],
        ['url' => $timeline->entity->url('show'), 'label' => $timeline->name],
        __('timelines/eras.edit.title', ['name' => $model->name])
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('timelines/eras.edit.title', ['name' => $model->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($model, ['route' => ['timelines.timeline_eras.update', 'timeline' => $timeline, 'timeline_era' => $model],
                'method' => 'PATCH',
                'data-shortcut' => 1,
                'id' => 'timeline-era-form',
                'enctype' => 'multipart/form-data'
               ]) !!}
            @include('timelines.eras._form')

            <div class="form-era">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                    {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            @if(!empty($from))
                <input type="hidden" name="from" value="{{ $from }}">
            @endif

            {!! Form::close() !!}
        </div>
    </div>
@endsection
