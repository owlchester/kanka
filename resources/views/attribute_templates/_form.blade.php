@inject('formService', 'App\Services\FormService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('attribute_templates.fields.name') }}</label>
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('attribute_templates.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    {!! Form::select2(
                        'attribute_template_id',
                        (isset($model) && $model->attributeTemplate ? $model->attributeTemplate : $formService->prefillSelect('attributeTemplate', $source)),
                        App\Models\AttributeTemplate::class,
                        true,
                        __('attribute_templates.fields.attribute_template'),
                        null,
                        __('attribute_templates.placeholders.attribute_template')
                    ) !!}
                </div>

                @if (Auth::user()->isAdmin())
                    <hr>
                    @include('cruds.fields.private')
                @endif
            </div>
        </div>
        @include('cruds.fields.copy')
    </div>
</div>

@include('cruds.fields.save')
