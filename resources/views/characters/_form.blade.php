{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}

            <label>Title:</label>
            {!! Form::text('title', null, ['placeholder' => 'Title', 'class' => 'form-control']) !!}

            <label>Family:</label>
            {!! Form::select('family_id', (isset($character) && $character->family ? [$character->family_id => $character->family->name] : []),
            null, ['id' => 'family_id', 'class' => 'form-control select2', 'data-url' => route('families.find'), 'data-placeholder' => 'Choose a family...']) !!}


            <label>Location:</label>
            {!! Form::select('location_id', (isset($character) && $character->location ? [$character->location_id => $character->location->name] : []),
            null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => 'Choose a location...']) !!}

            <label>Race:</label>
            {!! Form::text('race', null, ['placeholder' => 'Race', 'class' => 'form-control']) !!}
        </div>
        <hr />

        <div class="form-group">
            <label>Age:</label>
            {!! Form::text('age', null, ['placeholder' => 'Age', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Sex:</label>
            {!! Form::text('sex', null, ['placeholder' => 'Sex', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Height:</label>
            {!! Form::text('height', null, ['placeholder' => 'Height', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Weight:</label>
            {!! Form::text('weight', null, ['placeholder' => 'Weight', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Eye:</label>
            {!! Form::text('eye_colour', null, ['placeholder' => 'Eye', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Hair:</label>
            {!! Form::text('hair', null, ['placeholder' => 'Hair', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Skin:</label>
            {!! Form::text('skin', null, ['placeholder' => 'Skin', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Languages:</label>
            {!! Form::text('languages', null, ['placeholder' => 'Languages', 'class' => 'form-control']) !!}
        </div>

        <hr>

        <div class="form-group">
            <label>File:</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>History:</label>
            {!! Form::textarea('history', null, ['placeholder' => 'History', 'class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
        <hr />
        <div class="form-group">
            <label>Traits:</label>
            {!! Form::textarea('traits', null, ['placeholder' => 'Traits', 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>Goals:</label>
            {!! Form::textarea('goals', null, ['placeholder' => 'Goals', 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>Fears:</label>
            {!! Form::textarea('fears', null, ['placeholder' => 'Fears', 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>Mannerisms:</label>
            {!! Form::textarea('mannerisms', null, ['placeholder' => 'Mannerisms', 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>Free text:</label>
            {!! Form::textarea('free', null, ['placeholder' => 'Free text', 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    or <a href="{{ url()->previous() }}">cancel</a>
</div>
