{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('profiles.fields.theme') }}</label>
            {!! Form::select('theme', ['' => trans('profiles.theme.themes.default'), 'future' => trans('profiles.theme.themes.future')], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
