<p>{{ trans('campaigns.export.helper') }}</p>
<p>{!! __('campaigns.export.helper_secondary', [
    'api' => link_to('/docs/1.0', __('front.menu.api'))
]) !!}</p>


{!! Form::open(['method' => 'POST', 'route' => ['campaign_export']]) !!}
<div class="form-group">
    <button class="btn btn-primary"><i class="fa fa-download"></i> {{ trans('crud.export') }}</button>
</div>

{!! Form::close() !!}
