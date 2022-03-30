@include('partials.errors')

<div class="alert alert-danger" style="display: none;" id="entity-form-generic-error">
    <strong>{{ __('partials.errors.title') }}</strong>
    {{ __('partials.errors.description') }}<br>
    <div class="error-logs"></div>
</div>
<div class="alert alert-danger" style="display: none" id="entity-form-403-error">
    <strong>{{ __('errors.403.title') }}</strong><br />
    <p>{!! __('errors.403.body') !!}</p>
    <p>{!! __('errors.403-form.help') !!}</p>
</div>
