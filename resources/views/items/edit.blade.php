@extends('layouts.app', [
    'title' => trans('items.show.title', ['item' => $item->name]),
    'description' => trans('items.show.description'),
    'breadcrumbs' => [
        ['url' => route('items.index'), 'label' => trans('items.index.title')],
        ['url' => route('items.show', $item->id), 'label' => $item->name],
        trans('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($item, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['items.update', $item->id]]) !!}
                        @include('items._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
