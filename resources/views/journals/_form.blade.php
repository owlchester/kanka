{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Type:</label>
            {!! Form::text('type', null, ['placeholder' => 'Type', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>File:</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Date:</label>
            <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            {!! Form::text('date', null, ['placeholder' => 'Date', 'id' => 'date', 'class' => 'form-control date-picker']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>History:</label>
            {!! Form::textarea('history', null, ['placeholder' => 'History', 'class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
        <hr />
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
