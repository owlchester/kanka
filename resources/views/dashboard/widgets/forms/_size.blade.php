<div class="field-size">
    <label>{{ __('dashboard.widgets.fields.size') }}</label>
    {!! Form::select('config[size]', [
        'h1' => 'H1',
        'h2' => 'H2',
        null => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
        'h6' => 'H6',
    ], null, ['class' => 'form-control']) !!}
</div>
