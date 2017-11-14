{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('characters.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('characters.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.title') }}</label>
            {!! Form::text('title', null, ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.family') }}</label>
            {!! Form::select('family_id', (isset($character) && $character->family ? [$character->family_id => $character->family->name] : []),
            null, ['id' => 'family_id', 'class' => 'form-control select2', 'data-url' => route('families.find'), 'data-placeholder' => trans('characters.placeholders.family')]) !!}

        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.location') }}</label>
            {!! Form::select('location_id', (isset($character) && $character->location ? [$character->location_id => $character->location->name] : []),
            null, ['id' => 'location_id', 'class' => 'form-control select2', 'data-url' => route('locations.find'), 'data-placeholder' => trans('characters.placeholders.location')]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.race') }}</label>
            {!! Form::text('race', null, ['placeholder' => trans('characters.placeholders.race'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
        <hr />

        <div class="form-group">
            <label>{{ trans('characters.fields.age') }}</label>
            {!! Form::text('age', null, ['placeholder' => trans('characters.placeholders.age'), 'class' => 'form-control', 'maxlength' => 9]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.sex') }}</label>
            {!! Form::text('sex', null, ['placeholder' => trans('characters.placeholders.sex'), 'class' => 'form-control', 'maxlength' => 10]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.height') }}</label>
            {!! Form::text('height', null, ['placeholder' => trans('characters.placeholders.height'), 'class' => 'form-control', 'maxlength' => 10]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.weight') }}</label>
            {!! Form::text('weight', null, ['placeholder' => trans('characters.placeholders.weight'), 'class' => 'form-control', 'maxlength' => 10]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.eye') }}</label>
            {!! Form::text('eye_colour', null, ['placeholder' => trans('characters.placeholders.eye'), 'class' => 'form-control', 'maxlength' => 12]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.hair') }}</label>
            {!! Form::text('hair', null, ['placeholder' => trans('characters.placeholders.hair'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.skin') }}</label>
            {!! Form::text('skin', null, ['placeholder' => trans('characters.placeholders.skin'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.languages') }}</label>
            {!! Form::text('languages', null, ['placeholder' => trans('characters.placeholders.languages'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        <hr>
        <div class="form-group">
            <label>{{ trans('characters.fields.image') }}</label>
            {!! Form::hidden('remove-image') !!}
            {!! Form::file('image', array('class' => 'image')) !!}
            @if (!empty($character->image))
                <div class="preview">
                    <div class="image">
                        <img src="/storage/{{ $character->image }}"/>
                        <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                        </a>
                    </div>
                    <br class="clear">
                </div>
            @endif
        </div>

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
            <label>{{ trans('characters.fields.history') }}</label>
            {!! Form::textarea('history', null, ['placeholder' => trans('characters.placeholders.history'), 'class' => 'form-control html-editor', 'id' => 'history']) !!}
        </div>
        <hr />
        <div class="form-group">
            <label>{{ trans('characters.fields.traits') }}</label>
            {!! Form::textarea('traits', null, ['placeholder' => trans('characters.placeholders.traits'), 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.goals') }}</label>
            {!! Form::textarea('goals', null, ['placeholder' => trans('characters.placeholders.goals'), 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.fears') }}</label>
            {!! Form::textarea('fears', null, ['placeholder' => trans('characters.placeholders.fears'), 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.mannerisms') }}</label>
            {!! Form::textarea('mannerisms', null, ['placeholder' => trans('characters.placeholders.mannerisms'), 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.free') }}</label>
            {!! Form::textarea('free', null, ['placeholder' => trans('characters.placeholders.free'), 'class' => 'form-control', 'rows' => 4]) !!}
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => url()->previous()]) !!}</div>
