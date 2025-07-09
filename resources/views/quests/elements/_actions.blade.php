<x-dropdowns.item
    :link="route('quests.quest_elements.edit', [$campaign, $model, $element])"
    icon="edit">
    {{ __('crud.edit') }}
</x-dropdowns.item>
<x-dropdowns.divider></x-dropdowns.divider>
@php
    $url = route('confirm-delete', [$campaign, 'route' => route('quests.quest_elements.destroy', [$campaign, $model, $element]), 'name' => $element->name()]);
@endphp
<x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :data="['toggle' => 'dialog', 'target' => 'primary-dialog', 'url' => $url]" icon="trash">
    {{ __('posts.remove.title') }}
</x-dropdowns.item>
