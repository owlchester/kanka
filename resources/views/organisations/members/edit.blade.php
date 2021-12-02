@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('organisations.members.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])
@section('content')
    {!! Form::model($member, ['method' => 'PATCH', 'route' => ['organisations.organisation_members.update', $model->id, $member->id]]) !!}


    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ __('organisations.members.edit.title', ['name' => $model->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            @include('organisations.members._form')
        </div>

        <div class="panel-footer text-right">
            <button class="btn btn-success">{{ __('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>

    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection
