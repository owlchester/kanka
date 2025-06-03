<x-grid type="1/1">
    <x-helper>
        <p>{!! __('posts.visibility.helper', ['name' => $post->name]) !!}</p>
    </x-helper>
    @include('cruds.fields.visibility_id')
</x-grid>
