<h2 class="page-header with-border">
    {{ __('campaigns.show.tabs.export') }}
</h2>

<p>{{ trans('campaigns.export.helper') }}</p>


{!! Form::open(['method' => 'POST', 'route' => ['campaign_export']]) !!}
<div class="form-group">
    <button class="btn btn-primary"><i class="fa fa-download"></i> {{ trans('crud.export') }}</button>
</div>

{!! Form::close() !!}