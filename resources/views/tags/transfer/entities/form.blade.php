<x-grid type="1/1">
    <x-helper>
        {!! __('tags.transfer.entities.helper', ['name' => $tag->name]) !!}
    </x-helper>

    @include('cruds.fields.tag', ['model' => $tag->entity, 'allowNew' => false])
</x-grid>
