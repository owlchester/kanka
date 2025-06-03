<x-grid type="1/1">
    <x-helper>
        <p>{!! __('tags.transfer.entities.helper', ['name' => $tag->name]) !!}</p>
    </x-helper>

    @include('cruds.fields.tag', ['model' => $tag->entity, 'allowNew' => false])
</x-grid>
