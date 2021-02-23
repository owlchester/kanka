<?php
$horizontalForm = isset($horizontalForm) ? $horizontalForm : false;
?>
<div class="form-group">
    <label @if($horizontalForm) class="control-label col-sm-3 col-lg-2" @endif>{{ trans($trans . '.fields.position') }}</label>
    @if($horizontalForm) <div class="col-sm-9 col-lg-10"> @endif
        {!! Form::number('position', FormCopy::field('position')->string(), ['class' => 'form-control', 'maxlength' => 1]) !!}

    <p class="help-block">{{ __($trans . '.helpers.position') }}</p>
    @if ($horizontalForm) </div> @endif
</div>
