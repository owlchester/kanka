<x-grid type="1/1">
    <x-helper>
        {!! __('posts.move.helper', ['name' => $post->name]) !!}
    </x-helper>
    <x-forms.field field="entity" :label="__('entities/notes.move.entity')" required>
        <select name="entity" class=" select2" data-url="{{ route('search.entities-with-relations', $campaign) }}" data-allow-clear="false" data-allow-new="false" data-placeholder="{{ __('entities/notes.move.description') }}"></select>
    </x-forms.field>

    <x-forms.field field="copy" css="form-check" :label="__('entities/notes.move.copy_title')">
        <x-checkbox :text="__('posts.move.copy.helper', ['name' => $entity->name])">
            <input type="checkbox" name="copy" value="1" @if (old('copy', true)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
</x-grid>
