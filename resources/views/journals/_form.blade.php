{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('journals.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('journals.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('journals.fields.type') }}</label>
            {!! Form::text('type', null, ['placeholder' => trans('journals.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('journals.fields.image') }}</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('journals.fields.date') }}</label>
            <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            {!! Form::text('date', null, ['placeholder' => trans('journals.placeholders.date'), 'id' => 'date', 'class' => 'form-control date-picker']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ trans('journals.fields.history') }}</label>
            {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>

        <h4>{{ trans('journals.helpers.title') }}</h4>
        <p>{!! trans('journals.helpers.description') !!}</p>
        <hr />
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
