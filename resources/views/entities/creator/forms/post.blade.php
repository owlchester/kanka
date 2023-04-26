@include('cruds.fields.entity', ['required' => true])

<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control  resize-y', 'rows' => 5]) !!}
</div>

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.visibility_id')
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                {{ __('entities/notes.fields.position') }}
            </label>
            {!! Form::select('position', [0 => __('posts.position.last'), 1 => __('posts.position.first')], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
