<x-grid type="1/1">
    <p class="text-neutral-content m-0">
        {{ __('tags.transfer.description') }}
    </p>

    @include('cruds.fields.tag', ['model' => $tag->entity, 'allowNew' => false])
</x-grid>
