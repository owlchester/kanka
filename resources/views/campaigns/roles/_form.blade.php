{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('campaigns.roles.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('campaigns.roles.placeholders.name'), 'class' => 'form-control', 'maxlength' => 45, 'required']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
