<x-grid type="1/1">
    <x-helper>
        {!! __('posts.visibility.helper', ['name' => $post->name]) !!}
    </x-helper>
    @include('cruds.fields.visibility_id')
</x-grid>
