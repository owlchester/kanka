<x-form :action="['entity_types.update', $campaign, $entityType]" method="PATCH" class="w-full max-w-lg" files>
    @include('partials.forms._dialog', [
        'title' => __('campaigns/modules.rename.title', ['module' => $entityType->plural()]),
        'content' => 'campaigns.entity-types._form',
        'actions' => 'campaigns.entity-types._actions',
    ])
</x-form>

