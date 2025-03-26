<x-form :action="['campaign-applications.save', $campaign]" class="text-left w-full max-w-lg">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/submissions.toggle.title'),
        'content' => 'campaigns.submissions._toggle_form',
        'save' => __('crud.actions.apply'),
    ])
</x-form>
