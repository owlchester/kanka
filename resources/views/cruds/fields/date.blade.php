<div class="date form-group">
   <label>{{ __('quests.fields.date') }}</label>
    {!! Form::date('date', FormCopy::field('date')->string(), ['class' => 'form-control date-picker']) !!}
</div>
