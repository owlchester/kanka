<x-form :action="['entity_types.store', $campaign]" method="POST" class="w-full max-w-lg">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/modules.create.title'),
        'content' => 'campaigns.entity-types._form',
        'submit' => __('campaigns/modules.actions.create')
    ])
</x-form>

