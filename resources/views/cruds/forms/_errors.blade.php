@include('partials.errors')

<x-alert type="error" :hidden="true" id="entity-form-generic-error">
    <strong>{{ __('partials.errors.title') }}</strong>
    {{ __('partials.errors.description') }}<br>
    <div class="error-logs"></div>
</x-alert>
<x-alert type="error" :hidden="true"  id="entity-form-403-error">
    <strong>{{ __('errors.403.title') }}</strong><br />
    <p>{!! __('errors.403.body') !!}</p>
    <p>{!! __('errors.403-form.help') !!}</p>
</x-alert>
