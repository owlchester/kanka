@php
    $canOpen = $campaign->flags->contains('flag', \App\Enums\CampaignFlags::CanOpen->value);
    $statusOptions = [
        0 => __('campaigns/applications.toggle.closed')
    ];

    if ($canOpen) {
        $statusOptions[1] = __('campaigns/applications.toggle.open');
    }
@endphp

<x-forms.field
    field="status"
    required
    :label="__('campaigns/applications.toggle.label')"
    :helper="$canOpen ? __('campaigns/applications.helpers.modal') : __('campaigns/applications.helpers.fill_setup')">
    
    <x-forms.select 
        name="status" 
        radio 
        :options="$statusOptions" 
        :selected="$campaign->is_open ?? 0" 
    />
</x-forms.field>
