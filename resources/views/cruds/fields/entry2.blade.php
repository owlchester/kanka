<?php
$old = old('entry');
?>

<div class="form-group">
    <label style="width: 100%">
        {{ __('crud.panels.entry') }}

        <a href="{{ route('helpers.link') }}" class="pull-right btn btn-default btn-sm"
           data-url="{{ route('helpers.link') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('helpers.link.description') }}">
            <i class="fa-solid fa-question-circle"></i> {{ __('crud.helpers.linking') }}
        </a>
    </label>
    {!! Form::textarea(
        'entryForEdition',
        !empty($old) ? $old : FormCopy::field('entryForEdition')->string(),
        [
            'class' => 'form-control html-editor',
            'id' => 'entry',
            'name' => 'entry'
        ]
    ) !!}
</div>
