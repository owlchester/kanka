<?php /**
 * @var \App\Models\Post $post
 * @var \App\Models\Entity $entity
 */
?>
@can('post', [$entity, 'edit', $post])
    <x-dropdowns.item :link="route('entities.posts.edit', [$campaign, 'entity' => $entity, 'post' => $post, 'from' => 'main'])" icon="edit">
        {{ __('crud.edit') }}
    </x-dropdowns.item>
@endcan
@if (!isset($more))
    @php
        $title = '[post:' . $post->id . ']';
        $data = [
            'title' => $title,
            'toggle' => 'tooltip',
            'clipboard' => $title,
            'toast' => __('entities/notes.copy_mention.success')
    ]; @endphp
    <x-dropdowns.item link="#" :data="$data" icon="fa-regular fa-link">
        {{ __('entities/notes.copy_mention.copy') }}
    </x-dropdowns.item>
@endif
@if(auth()->user()->isAdmin())
    <x-dropdowns.item :link="route('posts.move', [$campaign, 'entity' => $entity, 'post' => $post, 'from' => 'main'])"  icon="fa-regular fa-arrows-left-right">
        {{ __('entities/notes.move.move') }}
    </x-dropdowns.item>
@endif
@can('setPostTemplates', $campaign)
    <x-dropdowns.item :link="route('posts.template', [$campaign, 'post' => $post])" :icon="($post->isTemplate() ? 'fa-regular' : 'fa-solid') . ' fa-star'">
        @if ($post->isTemplate())
            {{ __('entities/actions.templates.unset') }}
        @else
            {{ __('entities/actions.templates.set') }}
        @endif
    </x-dropdowns.item>
@endcan
@can('update', $entity)
    <x-dropdowns.item :link="route('entities.posts.logs', [$campaign, $entity, $post])" icon="fa-regular fa-history">
        {{ __('crud.history.view') }}
    </x-dropdowns.item>
@endcan
<hr class="m-0" />
<x-dropdowns.item :link="route('entities.story.reorder', [$campaign, 'entity' => $entity])" icon="fa-regular fa-arrows-v">
    {{ __('entities/story.reorder.icon_tooltip') }}
</x-dropdowns.item>
