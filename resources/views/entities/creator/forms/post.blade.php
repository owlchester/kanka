@include('cruds.fields.entity', ['required' => true])

<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control  resize-y', 'rows' => 5]) !!}
</div>

<x-grid>
    @include('cruds.fields.visibility_id')

    <div class="form-group">
        <label>
            {{ __('entities/notes.fields.position') }}
        </label>
        {!! Form::select('position', [0 => __('posts.position.last'), 1 => __('posts.position.first')], null, ['class' => 'form-control']) !!}
    </div>
</x-grid>
