
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'abilities'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.ability', ['parent' => true, 'from' => isset($model) ? $model : null, 'quickCreator' => true])
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('abilities.fields.charges') }}</label>
            {!! Form::text(
                'charges',
                FormCopy::field('charges')->string(),
                [
                    'placeholder' => trans('abilities.placeholders.charges'),
                    'class' => 'form-control',
                    'maxlength' => 120,
                    'autocomplete' => 'off'
                ]
            ) !!}
        </div>
    </div>
</div>


@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')
