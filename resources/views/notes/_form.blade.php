{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('notes.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('notes.placeholders.name'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('notes.fields.type') }}</label>
            {!! Form::text('type', null, ['placeholder' => trans('notes.placeholders.type'), 'class' => 'form-control']) !!}
        </div>

        <hr />

        <div class="form-group">
            <label>{{ trans('notes.fields.image') }}</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('notes.fields.description') }}</label>
            {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
