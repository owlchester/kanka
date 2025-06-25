<x-forms.field
    field="status"
    required
    :label="__('campaigns/applications.toggle.label')"
    :helper="__('campaigns/applications.helpers.modal')">
    <x-forms.select name="status" radio :options="[0 => __('campaigns/applications.toggle.closed'), 1 => __('campaigns/applications.toggle.open')]" :selected="$campaign->is_open ?? null" />
</x-forms.field>
