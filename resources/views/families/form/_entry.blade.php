@inject('formService', 'App\Services\FormService')

<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('families.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('families.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            {!! Form::select2(
                'family_id',
                (isset($model) && $model->family ? $model->family : $formService->prefillSelect('family', $source)),
                App\Models\Family::class,
                true,
                'families.fields.family'
            ) !!}
        </div>
        @include('cruds.fields.location')
        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>