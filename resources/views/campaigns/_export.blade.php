
<p>{{ trans('campaigns.export.helper') }}</p>


{!! Form::open(['method' => 'POST', 'route' => ['campaigns.export', $campaign]]) !!}
<div class="form-group">
    <button class="btn btn-primary"><i class="fa fa-download"></i> {{ trans('crud.export') }}</button>
</div>

{!! Form::close() !!}