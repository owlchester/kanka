@include('partials.errors')

@if (!empty($model))
    {!! Form::model(
    $model,
    [
        'method' => 'PATCH',
        'route' => ['campaign_dashboard_widgets.update', $model],
        'data-shortcut' => '1'
    ]
) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}" title="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
            {{ trans('dashboard.setup.actions.edit') }}
        </h4>
    </div>
    <div class="modal-body">
@else
    {!! Form::open([
        'route' => ['campaign_dashboard_widgets.store'],
        'method'=>'POST',
        'data-shortcut' => '1'
    ]) !!}
@endif

    {{ csrf_field() }}

    @include('dashboard.widgets.forms._' . $widget)


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
            </div>
            <input type="hidden" name="widget" value="{{ $widget }}">
            {!! Form::close() !!}
        </div>
        <div class="col-md-6 text-right">
            @if (!empty($model))
            {!! Form::open(['method' => 'DELETE','route' => ['campaign_dashboard_widgets.destroy', $model], 'class' => 'form-inline']) !!}
            <button class="btn btn-danger">
                <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-md">{{ trans('crud.remove') }}</span>
            </button>
            {!! Form::close() !!}
        </div>
        @endif
    </div>

</div>