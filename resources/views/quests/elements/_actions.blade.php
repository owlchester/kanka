<x-dropdowns.item
    :link="route('quests.quest_elements.edit', [$campaign, $model, $element])"
    icon="edit">
    {{ __('crud.edit') }}
</x-dropdowns.item>
<x-dropdowns.divider></x-dropdowns.divider>
@php
    $url = route('confirm-delete', [$campaign, 'route' => route('quests.quest_elements.destroy', [$campaign, $model, $element]), 'name' => $element->name(), 'permanent' => true]);
@endphp
<x-dropdowns.item link="#" css="text-error-content hover:bg-error" :data="['toggle' => 'dialog', 'target' => 'primary-dialog', 'url' => $url]" icon="trash">
    {{ __('crud.remove') }}
</x-dropdowns.item>
