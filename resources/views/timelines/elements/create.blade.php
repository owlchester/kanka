<?php /**
 * @var \App\Models\Timeline $timeline
 * @var \App\Models\TimelineElement $model
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('timelines/elements.create.title', ['name' => $timeline->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('timelines.index'), 'label' => __('timelines.index.title')],
        ['url' => $timeline->entity->url('show'), 'label' => $timeline->name],
        __('timelines/elements.create.title')
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('timelines/elements.create.title', ['name' => $timeline->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['route' => ['timelines.timeline_elements.store', $timeline],
                'method' => 'POST',
                'data-shortcut' => 1,
                'id' => 'timeline-element-form',
                'enctype' => 'multipart/form-data'
               ]) !!}
            @include('timelines.elements._form', ['model' => null])

            <div class="form-element">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                    {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
