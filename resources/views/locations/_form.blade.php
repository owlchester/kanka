{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('locations.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('locations.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('locations.fields.type') }}</label>
            {!! Form::text('type', null, ['placeholder' => trans('locations.placeholders.type'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('locations.fields.location') }}</label>
            {!! Form::select('parent_location_id', (!empty($location->parentLocation) ? [$location->parent_location_id => $location->parentLocation->name] : []), null, ['id' => 'parent_location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => trans('locations.placeholders.location')]) !!}

        </div>
        <hr />

        <div class="form-group">
            <label>{{ trans('locations.fields.image') }}</label>

            {!! Form::hidden('remove-image') !!}
            {!! Form::file('image', array('class' => 'image')) !!}
            @if (!empty($location->image))
                <div class="preview">
                    <div class="image">
                        <img src="/storage/{{ $location->image }}"/>
                        <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                        </a>
                    </div>
                    <br class="clear">
                </div>
            @endif        </div>

        <hr>
        <div class="form-group">
            {!! Form::hidden('is_private', 0) !!}
            <label>{!! Form::checkbox('is_private') !!}
                {{ trans('characters.fields.is_private') }}
            </label>
            <p class="help-block">{{ trans('characters.hints.is_private') }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('locations.fields.description') }}</label>
            {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>
        <hr />
        <div class="form-group">
            <label>{{ trans('locations.fields.history') }}:</label>
            {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
        <hr />
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
