@php
$usages = [
    '' => __('campaigns.invites.usages.no_limit'),
    '1' => __('campaigns.invites.usages.once'),
    '5' => __('campaigns.invites.usages.five'),
    '10' => __('campaigns.invites.usages.ten'),
];
@endphp

{{ csrf_field() }}
<div class="form-group required">
@if ($type == 'email')
    <label>
        {{ __('campaigns.invites.fields.email') }}
        <i class="fa fa-question-circle hidden-xs hidden-sm" title="{{ __('campaigns.invites.helpers.email') }}" data-toggle="tooltip"></i>
    </label>
    {!! Form::text('email', null, ['placeholder' => trans('campaigns.invites.placeholders.email'), 'class' => 'form-control']) !!}
        <p class="help-block visible-xs visible-sm">{{  __('campaigns.invites.helpers.email')}}</p>
@else
    <label>{{ trans('campaigns.invites.fields.usage') }}</label>
    {!! Form::select('validity', $usages, null, ['class' => 'form-control']) !!}
@endif
</div>

<div class="form-group required">
    <label>{{ trans('campaigns.invites.fields.role') }}</label>
    {!! Form::select('role_id', Auth::user()->campaign->roles()->where(['is_public' => false, 'is_admin' => false])->pluck('name', 'id'), null, ['class' => 'select form-control']) !!}
</div>


{!! Form::hidden('type_id', $typeID) !!}
