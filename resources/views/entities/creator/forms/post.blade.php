<x-grid>
    <div class="col-span-2">
        @include('cruds.fields.entity', ['required' => true])
    </div>

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">
        {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control  resize-y', 'rows' => 5]) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id')

    <x-forms.field field="position" :label="__('entities/notes.fields.position')">
        {!! Form::select('position', [0 => __('posts.position.last'), 1 => __('posts.position.first')], null, ['class' => 'form-control']) !!}
    </x-forms.field>
</x-grid>
