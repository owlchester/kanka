<x-forms.field
    field="status"
    :required="true"
    :label="__('campaigns/submissions.toggle.label')"
    :helper="__('campaigns/submissions.helpers.modal')">
    {!! Form::select('status', [0 => __('campaigns/submissions.toggle.closed'), 1 => __('campaigns/submissions.toggle.open')], $campaign->is_open, ['class' => 'w-full']) !!}
</x-forms.field>
