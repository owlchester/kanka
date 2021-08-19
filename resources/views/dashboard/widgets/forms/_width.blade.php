<div class="form-group required">
    <label>{{ __('dashboard.widgets.fields.width') }}</label>
    {!! Form::select('width', [
        0 => __('dashboard.widgets.widths.0'),
        12 => __('dashboard.widgets.widths.12'),
        3 => __('dashboard.widgets.widths.3'),
        4 => __('dashboard.widgets.widths.4'),
        6 => __('dashboard.widgets.widths.6'),
        8 => __('dashboard.widgets.widths.8'),
        9 => __('dashboard.widgets.widths.9')
    ], null, ['class' => 'form-control']) !!}
</div>
