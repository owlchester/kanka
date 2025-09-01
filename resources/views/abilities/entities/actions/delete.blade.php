<x-dropdowns.item
    link="#"
    css="text-error hover:bg-error hover:text-error-content"
    :dialog="route('confirm-delete', [$campaign, 'route' => route('entities.entity_abilities.destroy', [
    $campaign,
    'entity' => $model,
    'entity_ability' => $model->pivot->id,
    'from' => 'ability'
    ]), 'name' => $model->name, 'permanent' => true])"
    icon="trash">
    {{ __('crud.remove') }}
</x-dropdowns.item>
