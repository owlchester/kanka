<x-form :action="['entity_types.store', $campaign]" method="POST" class="w-full max-w-lg">
    @include('partials.forms.form', [
        'title' => __('campaigns/modules.create.title'),
        'content' => 'campaigns.entity-types._form',
        'dialog' => true,
    ])
</x-form>

