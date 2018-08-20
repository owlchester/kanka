{{ csrf_field() }}
<div class="form-group">
    <label>{{ trans('profiles.settings.fields.pagination') }}</label>
    {!! Form::select('default_pagination', [
        15 => 15,
        25 => 25,
        45 => 45
    ], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>{{ trans('profiles.settings.fields.date_format') }}</label>
    {!! Form::select('date_format', [
        'Y-m-d' => 'Y-m-d',
        'd.m.Y' => 'd.m.Y',
        'd-m-y' => 'd-m-y',
        'm/d/Y' => 'm/d/Y'

    ], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
