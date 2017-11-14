{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('organisations.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('organisations.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('organisations.fields.location') }}</label>
            {!! Form::select('location_id', (isset($organisation) && !empty($organisation->location) ? [$organisation->location_id => $organisation->location->name] : []), null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => trans('organisations.placeholders.location')]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('organisations.fields.type') }}</label>
            {!! Form::text('type', null, ['placeholder' => trans('organisations.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        <hr />

        <div class="form-group">
            <label>{{ trans('organisations.fields.image') }}</label>

            {!! Form::hidden('remove-image') !!}
            {!! Form::file('image', array('class' => 'image')) !!}
            @if (!empty($organisation->image))
                <div class="preview">
                    <div class="image">
                        <img src="/storage/{{ $organisation->image }}"/>
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
            <label>{{ trans('organisations.fields.history') }}</label>
            {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}
</div>
