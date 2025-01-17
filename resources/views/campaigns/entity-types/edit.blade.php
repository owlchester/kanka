<x-form :action="['entity_types.update', $campaign, $entityType]" method="PATCH" class="w-full max-w-lg">
    @include('partials.forms.form', [
        'title' => __('campaigns/modules.rename.title', ['module' => $entityType->plural()]),
        'content' => 'campaigns.entity-types._form',
        'actions' => 'campaigns.entity-types._actions',
        'dialog' => true,
    ])
</x-form>

