<x-form :action="['campaign-applications.save', $campaign]" class="text-left w-full max-w-lg">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/applications.toggle.title'),
        'content' => 'campaigns.applications._toggle_form',
        'save' => __('crud.actions.apply'),
    ])
</x-form>
