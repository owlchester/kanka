@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('organisations.members.create.title', ['name' => $model->name]),
    'description' => trans('organisations.members.create.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ trans('organisations.members.create.title', ['name' => $model->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(array('route' => ['organisations.organisation_members.store', $model->id], 'method'=>'POST')) !!}
            @include('organisations.members._form')
            {!! Form::hidden('organisation_id', $model->id) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
