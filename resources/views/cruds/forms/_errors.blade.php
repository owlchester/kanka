@include('partials.errors')

<div class="alert alert-danger" style="display: none;" id="entity-form-generic-error">
    <strong>{{ trans('partials.errors.title') }}</strong>
    {{ trans('partials.errors.description') }}<br>
</div>
<div class="alert alert-danger" style="display: none" id="entity-form-503-error">
    <strong>{{ trans('errors.503-form.title') }}</strong><br />
    <p>{!! trans('errors.503-form.body', ['link' => link_to('home', __('errors.503-form.link'), ['target' => '_blank'])]) !!}</p>
</div>
<div class="alert alert-danger" style="display: none" id="entity-form-403-error">
    <strong>{{ trans('errors.403.title') }}</strong><br />
    <p>{!! trans('errors.403.body') !!}</p>
    <p>{!! trans('errors.403-form.help') !!}</p>
</div>
