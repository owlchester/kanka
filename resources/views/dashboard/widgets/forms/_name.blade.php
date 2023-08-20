<div class="field-name">
    <label>{{ __('dashboard.widgets.fields.name') }}@if(isset($random)) <i class="fa-solid fa-question-circle" data-toggle="tooltip" data-title="{{ __('dashboard.widgets.random.helpers.name') }}" aria-hidden="true"></i>@endif</label>
    {!! Form::text('config[text]', null, ['class' => 'form-control']) !!}
</div>
