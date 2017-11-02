{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Location:</label>
            {!! Form::select('location_id', (isset($organisation) && !empty($organisation->location) ? [$organisation->location_id => $organisation->location->name] : []), null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => 'Choose a location...']) !!}
        </div>
        <div class="form-group">
            <label>Type:</label>
            {!! Form::text('type', null, ['placeholder' => 'Type', 'class' => 'form-control']) !!}
        </div>

        <hr />

        <div class="form-group">
            <label>Image:</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>History:</label>
            {!! Form::textarea('history', null, ['placeholder' => 'History', 'class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    or <a href="{{ url()->previous() }}">cancel</a>
</div>
