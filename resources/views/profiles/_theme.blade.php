{{ csrf_field() }}
<div class="form-group">
    {!! Form::select('theme', [
        '' => trans('profiles.theme.themes.default'),
        'dark' => trans('profiles.theme.themes.dark'),
        'future' => trans('profiles.theme.themes.future')
    ], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
