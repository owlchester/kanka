@php
    $required = !isset($bulk);
@endphp

<div class="form-group @if($required) required @endif">
    <label>{{ __('entities/relations.fields.relation') }}</label>
    {!! Form::text('relation', null, ['placeholder' => __('entities/relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
