<x-grid>
    <div class="col-span-2">
        @include('cruds.fields.entity', ['required' => true])
    </div>

    <x-forms.field field="entry" css="col-span-2" :label="__('posts.fields.description')">
        <textarea
            name="entry"
            class="resize-y"
            rows="5"
        >{!! FormCopy::field('entry')->string() !!}</textarea>
    </x-forms.field>

    @include('cruds.fields.visibility_id')

    <x-forms.field field="position" :label="__('entities/notes.fields.position')">
        <x-forms.select name="position" :options="[0 => __('posts.position.last'), 1 => __('posts.position.first')]" class="w-full" />
    </x-forms.field>
</x-grid>
