@php
$usages = [
    '' => __('campaigns.invites.usages.no_limit'),
    '1' => __('campaigns.invites.usages.once'),
    '5' => __('campaigns.invites.usages.five'),
    '10' => __('campaigns.invites.usages.ten'),
];
@endphp

{{ csrf_field() }}
<x-grid type="1/1">
    <div class="field-usage required">
        <label>{{ __('campaigns.invites.fields.usage') }}</label>
        {!! Form::select('validity', $usages, null, ['class' => 'form-control']) !!}
    </div>
    <div class="field-role required">
        <label>{{ __('campaigns.invites.fields.role') }}</label>
        {!! Form::select('role_id', auth()->user()->campaign->roles()->where(['is_public' => false, 'is_admin' => false])->pluck('name', 'id'), null, ['class' => 'select form-control']) !!}
    </div>
</x-grid>
