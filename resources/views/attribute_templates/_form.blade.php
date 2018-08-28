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
                    {!! Form::text('name', null, ['placeholder' => trans('attribute_templates.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@include('cruds.fields.save')
