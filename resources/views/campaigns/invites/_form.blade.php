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
    <x-forms.field
        field="usage"
        :required="true"
        :label="__('campaigns.invites.fields.usage')">
        {!! Form::select('validity', $usages, null, ['class' => 'w-full']) !!}
    </x-forms.field>

    <x-forms.field
        field="role"
        :required="true"
        :label="__('campaigns.invites.fields.role')">
        {!! Form::select('role_id', $campaign->roles()->where(['is_public' => false, 'is_admin' => false])->pluck('name', 'id'), null, ['class' => 'select w-full']) !!}
    </x-forms.field>
</x-grid>
