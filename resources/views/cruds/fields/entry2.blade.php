<div class="form-group">
    <label>{{ __('crud.panels.entry') }}</label>
    {!! Form::textarea(
        'entry',
        FormCopy::field('entry')->string(),
        [
            'class' => 'form-control html-editor',
            'id' => 'entry'
        ]
    ) !!}
    <div class="text-right">
        <a href="{{ route('helpers.link') }}" data-toggle="tooltip" title="{{ __('helpers.link.description') }}" target="_blank">{{ __('crud.linking_help') }}</a>
    </div>
</div>
