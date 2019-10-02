<p class="help-block">{{ __('campaigns.helpers.boosted') }}</p>

<div class="form-group">
    <label>{{ trans('crud.fields.tooltip') }}</label>
    <p class="help-block">{{ __('crud.hints.tooltip') }}</p>
    {!! Form::textarea('entity_tooltip', $formService->prefill('tooltip', $source), ['class' => 'form-control html-editor', 'id' => 'tooltip']) !!}
    <div class="text-right">
        <a href="{{ route('helpers.link') }}" data-toggle="tooltip" title="{{ trans('helpers.link.description') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
    </div>
</div>
