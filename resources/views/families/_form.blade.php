{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('families.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('families.placeholders.name'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('families.fields.location') }}</label>
            {!! Form::select('location_id', (isset($family) && !empty($family->location) ? [$family->location_id => $family->location->name] : []), null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => trans('families.placeholders.location')]) !!}
        </div>

        <hr />

        <div class="form-group">
            <label>{{ trans('families.fields.image') }}</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('families.fields.history') }}</label>
            {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
