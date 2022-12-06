@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('organisations.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('entities.organisations')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['organisations.organisation_members.store', $model->id], 'method'=>'POST')) !!}

    @if ($ajax)
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>{{ __('organisations.members.create.title', ['name' => $model->name]) }}</h4>
        </div>
        <div class="modal-body">
            @include('partials.errors')
            @include('organisations.members._form')
        </div>
        <div class="modal-footer">
            <button class="btn btn-success">{{ __('crud.save') }}</button>

            <div class="pull-left">
                @include('partials.footer_cancel')
            </div>
        </div>
    @else
        <div class="panel panel-default">
            <div class="panel-body">
                @include('partials.errors')
                @include('organisations.members._form')
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-success">{{ __('crud.save') }}</button>

                <div class="pull-left">
                    @include('partials.footer_cancel')
                </div>
            </div>
        </div>
    @endif
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection
