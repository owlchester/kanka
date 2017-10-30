{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}

            <label>Type:</label>
            {!! Form::text('type', null, ['placeholder' => 'Type', 'class' => 'form-control']) !!}

            <label>Location:</label>
            {!! Form::select('location_id', (isset($item) && $item->location ? [$item->location_id => $item->location->name] : []),
            null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => 'Choose a location...']) !!}

            <label>Character:</label>
            {!! Form::select('character_id', (isset($item) && $item->character ? [$item->character_id => $item->character->name] : []),
            null, ['id' => 'character_id', 'class' => 'form-control select2', 'data-url' => route('characters.find'), 'data-placeholder' => 'Choose a character...']) !!}

        </div>
        <hr />


        <div class="form-group">
            <label>File:</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Description:</label>
            {!! Form::textarea('description', null, ['placeholder' => 'Description', 'class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>
        <hr />
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
