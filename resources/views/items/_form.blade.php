{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('items.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('items.placeholders.name'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('items.fields.type') }}</label>
            {!! Form::text('type', null, ['placeholder' => trans('items.placeholders.type'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('items.fields.location') }}</label>
            {!! Form::select('location_id', (isset($item) && $item->location ? [$item->location_id => $item->location->name] : []),
            null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => trans('items.placeholders.location')]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('items.fields.character') }}</label>
            {!! Form::select('character_id', (isset($item) && $item->character ? [$item->character_id => $item->character->name] : []),
            null, ['id' => 'character_id', 'class' => 'form-control select2', 'data-url' => route('characters.find'), 'data-placeholder' => trans('items.placeholders.character')]) !!}
        </div>
        <hr />

        <div class="form-group">
            <label>{{ trans('items.fields.image') }}</label>
            {!! Form::file('image', array('class' => 'image')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('items.fields.description') }}</label>
            {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>
        <hr />
        <div class="form-group">
            <label>{{ trans('items.fields.history') }}</label>
            {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
        <hr />
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
