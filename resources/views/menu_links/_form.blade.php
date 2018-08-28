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
                    <label>{{ trans('menu_links.fields.name') }}</label>
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('menu_links.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    {!! Form::select2(
                        'entity_id',
                        (!empty($model) && $model->entity? $model->entity: null),
                        App\Models\Entity::class,
                        false,
                        'menu_links.fields.entity',
                        'search.relations',
                        'menu_links.placeholders.entity'
                    ) !!}
                </div>
                @include('cruds.fields.private')
            </div>
        </div>
    </div>
</div>

@include('cruds.fields.save')
