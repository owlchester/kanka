<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.note', ['isParent' => true])
    </div>
</div>

<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control resize-y', 'rows' => 5]) !!}
</div>
