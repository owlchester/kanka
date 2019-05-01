<div class="form-group">
    <label>{{ trans('crud.panels.entry') }}</label>
    {!! Form::textarea('entry', $formService->prefill('entry', $source), ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
    <div class="text-right">
        <a href="{{ route('helpers.link') }}" data-toggle="tooltip" title="{{ trans('helpers.link.description') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
    </div>
</div>
