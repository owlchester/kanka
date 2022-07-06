<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'tags'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tag', ['parent' => true, 'from' => isset($model) ? $model : null, 'quickCreator' => true])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.colour')
    </div>
</div>

@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::hidden('is_auto_applied', 0) !!}
            <label>{!! Form::checkbox('is_auto_applied', 1, $model->is_auto_applied ?? '' )!!}
                {{ __('tags.fields.is_auto_applied') }}
            </label>
            <p class="help-block">{{ __('tags.hints.is_auto_applied') }}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>

@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')
