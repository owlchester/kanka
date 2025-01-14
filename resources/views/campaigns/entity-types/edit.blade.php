<x-form :action="['campaign.entity_types.update', $campaign, $entityType]" method="PATCH" class="w-full max-w-lg">
    @include('partials.forms.form', [
        'title' => __('campaigns/modules.rename.title', ['module' => $entityType->plural()]),
        'content' => 'campaigns.entity-types._form',
        'dialog' => true,
        'deleteID' => '#delete-entity-type-' . $entityType->id,
    ])
</x-form>

<x-form method="DELETE" :action="['campaign.entity_types.destroy', $campaign, $entityType]" id="delete-entity-type-{{ $entityType->id }}" />

