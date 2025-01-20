<x-forms.field
    field="status"
    required
    :label="__('campaigns/submissions.toggle.label')"
    :helper="__('campaigns/submissions.helpers.modal')">
    <x-forms.select name="status" :options="[0 => __('campaigns/submissions.toggle.closed'), 1 => __('campaigns/submissions.toggle.open')]" :selected="$campaign->is_open ?? null" />
</x-forms.field>
