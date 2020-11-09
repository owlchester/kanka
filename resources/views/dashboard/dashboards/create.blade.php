@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('dashboard.dashboards.create.title'),
    'description' => '',
    'breadcrumbs' => []
])

@section('content')
    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('dashboard.dashboards.create.title') }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['route' => ['campaign_dashboards.store'], 'method' => 'POST', 'data-shortcut' => 1]) !!}
            @include('dashboard.dashboards._form')

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
