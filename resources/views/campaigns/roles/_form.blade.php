{{ csrf_field() }}
<div class="form-group required">
    <label>{{ trans('campaigns.roles.fields.name') }}</label>
    {!! Form::text('name', null, ['placeholder' => trans('campaigns.roles.placeholders.name'), 'class' => 'form-control', 'maxlength' => 45, 'required']) !!}
</div>

