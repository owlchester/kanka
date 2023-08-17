{{ csrf_field() }}
<div class="field-name required">
    <label>{{ trans('campaigns.roles.fields.name') }}</label>
    {!! Form::text('name', null, ['placeholder' => trans('campaigns.roles.placeholders.name'), 'class' => 'form-control', 'maxlength' => 45, 'required']) !!}
    @if (isset($roleId))
        <div class="field-duplicate-role checkbox">
            {!! Form::hidden('role_id', $roleId) !!}
            {!! Form::hidden('duplicate', 0) !!}
            <label>
                {!! Form::checkbox('duplicate', 1) !!}
                {{ __('campaigns.roles.fields.copy_permissions') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-title="{{ __('calendars.hints.skip_year_zero') }}" data-toggle="tooltip"></i>
            </label>
            <p class="help-block visible-xs visible-sm">{{ __('campaigns.roles.helper.permissions_helper') }}</p>
        </div>
    @endif
</div>

