<x-grid>
    <div class="col-span-2">
        @include('cruds.fields.entity', ['required' => true])
    </div>

    <div class="field-entry col-span-2">
        <label>{{ __('crud.fields.entry') }}</label>
        {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control  resize-y', 'rows' => 5]) !!}
    </div>

    @include('cruds.fields.visibility_id')

    <div class="field-position">
        <label>
            {{ __('entities/notes.fields.position') }}
        </label>
        {!! Form::select('position', [0 => __('posts.position.last'), 1 => __('posts.position.first')], null, ['class' => 'form-control']) !!}
    </div>
</x-grid>
