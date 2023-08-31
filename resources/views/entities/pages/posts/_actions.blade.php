@can('post', [$model, 'edit', $post])
    <x-dropdowns.item :link="route('entities.posts.edit', [$campaign, 'entity' => $entity, 'post' => $post, 'from' => 'main'])" icon="edit">
        {{ __('crud.edit') }}
    </x-dropdowns.item>
@endcan
@if (!isset($more))
    @php
        $title = '[' . $model->getEntityType() . ':' . $model->entity->id . '|anchor:post-' . $post->id . ']';
        $data = [
            'title' => $title,
            'toggle' => 'tooltip',
            'clipboard' => $title,
            'toast' => __('entities/notes.copy_mention.success')
    ]; @endphp
    <x-dropdowns.item link="#" :data="$data" icon="fa-solid fa-link">
        {{ __('entities/notes.copy_mention.copy') }}
    </x-dropdowns.item>
    @php
        $title = '[' . $model->getEntityType() . ':' . $model->entity->id . '|anchor:post-' . $post->id . '|' . $post->name . ']';
        $data = [
            'title' => $title,
            'toggle' => 'tooltip',
            'clipboard' => $title,
            'toast' => __('entities/notes.copy_mention.success')
    ]; @endphp
    <x-dropdowns.item link="#" :data="$data" icon="fa-solid fa-link">
        {{ __('entities/notes.copy_mention.copy_with_name') }}
    </x-dropdowns.item>
@endif
@if(auth()->user()->isAdmin())
    <x-dropdowns.item :link="route('posts.move', [$campaign, 'entity' => $entity, 'post' => $post, 'from' => 'main'])"  icon="fa-solid fa-arrows-left-right">
        {{ __('entities/notes.move.move') }}
    </x-dropdowns.item>
@endif
<hr class="m-0" />
<x-dropdowns.item :link="route('entities.story.reorder', [$campaign, 'entity' => $entity])" icon="fa-solid fa-arrows-v">
    {{ __('entities/story.reorder.icon_tooltip') }}
</x-dropdowns.item>
