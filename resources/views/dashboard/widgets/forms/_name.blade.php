<div class="form-group">
    <label>{{ __('dashboard.widgets.fields.name') }}@if(isset($random)) <i class="fas fa-question-circle" data-toggle="tooltip" title="{{ __('dashboard.widgets.random.helpers.name') }}"></i>@endif</label>
    {!! Form::text('config[text]', null, ['class' => 'form-control']) !!}
</div>
