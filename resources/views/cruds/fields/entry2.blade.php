<?php
$old = old('entry');
?>

<div class="form-group">
    <label>{{ __('crud.panels.entry') }}</label>
    {!! Form::textarea(
        'entryForEdition',
        !empty($old) ? $old : FormCopy::field('entryForEdition')->string(),
        [
            'class' => 'form-control html-editor',
            'id' => 'entry',
            'name' => 'entry'
        ]
    ) !!}
    <div class="text-right">
        <a href="{{ route('helpers.link') }}" data-url="{{ route('helpers.link') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('helpers.link.description') }}">
            {{ __('crud.linking_help') }} <i class="fa fa-question-circle"></i>
        </a>
    </div>
</div>
