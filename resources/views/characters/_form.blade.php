
@inject('location', 'App\Services\LocationService')
@inject('random', 'App\Services\RandomCharacterService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('characters.fields.name') }}</label>
                    {!! Form::text('name', $random->generate('name'), ['placeholder' => trans('characters.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.title') }}</label>
                    {!! Form::text('title', $random->generate('title'), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                @if ($campaign->enabled('families'))
                <div class="form-group">
                    <label>{{ trans('characters.fields.family') }}</label>
                    <div class="input-group input-group-sm">
                        {!! Form::select('family_id', (isset($model) && $model->family ? [$model->family_id => $model->family->name] : $random->generateForeign(App\Models\Family::class)),
                        null, ['id' => 'family_id', 'class' => 'form-control select2', 'style' => 'width: 100%', 'data-url' => route('families.find'), 'data-placeholder' => trans('characters.placeholders.family')]) !!}

                        <div class="input-group-btn">
                            <a class="new-entity-selector btn btn-tab-form" style="" data-toggle="modal" data-target="#new-entity-modal" data-parent="family_id" data-entity="families">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @if ($campaign->enabled('locations'))
                <div class="form-group">
                    <label>{{ trans('characters.fields.location') }}</label>
                    <div class="input-group input-group-sm">
                        {!! Form::select('location_id', (isset($model) ? $location->dropdown($model) : $random->generateForeign(App\Models\Location::class)),
                        null, ['id' => 'location_id', 'class' => 'form-control select2', 'style' => 'width: 100%', 'data-url' => route('locations.find'), 'data-placeholder' => trans('characters.placeholders.location')]) !!}

                        <div class="input-group-btn">
                            <a class="new-entity-selector btn btn-tab-form" style="" data-toggle="modal" data-target="#new-entity-modal" data-parent="location_id" data-entity="locations">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label>{{ trans('characters.fields.race') }}</label>
                    {!! Form::text('race', $random->generate('race'), ['placeholder' => trans('characters.placeholders.race'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>

                <div class="form-group">
                    {!! Form::hidden('is_private', 0) !!}
                    <label>{!! Form::checkbox('is_private') !!}
                        {{ trans('characters.fields.is_private') }}
                    </label>
                    <p class="help-block">{{ trans('characters.hints.is_private') }}</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.appearance') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('characters.fields.age') }}</label>
                    {!! Form::text('age', $random->generateNumber(1, 300), ['placeholder' => trans('characters.placeholders.age'), 'class' => 'form-control', 'maxlength' => 25]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.sex') }}</label>
                    {!! Form::text('sex', $random->generate('sex'), ['placeholder' => trans('characters.placeholders.sex'), 'class' => 'form-control', 'maxlength' => 10]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.height') }}</label>
                    {!! Form::text('height', $random->generateNumber('height'), ['placeholder' => trans('characters.placeholders.height'), 'class' => 'form-control', 'maxlength' => 10]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.weight') }}</label>
                    {!! Form::text('weight', $random->generateNumber('weight'), ['placeholder' => trans('characters.placeholders.weight'), 'class' => 'form-control', 'maxlength' => 10]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.eye') }}</label>
                    {!! Form::text('eye_colour', $random->generate('eye'), ['placeholder' => trans('characters.placeholders.eye'), 'class' => 'form-control', 'maxlength' => 12]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.hair') }}</label>
                    {!! Form::text('hair', $random->generate('hair'), ['placeholder' => trans('characters.placeholders.hair'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.skin') }}</label>
                    {!! Form::text('skin', $random->generate('skin'), ['placeholder' => trans('characters.placeholders.skin'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.languages') }}</label>
                    {!! Form::text('languages', $random->generate('language', 3), ['placeholder' => trans('characters.placeholders.languages'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>

                <div class="form-group">
                    <label>{{ trans('characters.fields.image') }}</label>
                    {!! Form::hidden('remove-image') !!}
                    {!! Form::file('image', array('class' => 'image')) !!}
                    @if (!empty($model->image))
                        <div class="preview">
                            <div class="image">
                                <img src="/storage/{{ $model->image }}"/>
                                <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                                    <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                                </a>
                            </div>
                            <br class="clear">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.history') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('characters.fields.history') }}</label>
                    {!! Form::textarea('history', null, ['placeholder' => trans('characters.placeholders.history'), 'class' => 'form-control html-editor', 'id' => 'history']) !!}
                </div>
                <div class="form-group">
                    <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('characters.sections.personality') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('characters.fields.traits') }}</label>
                    {!! Form::textarea('traits', $random->generate('trait'), ['placeholder' => trans('characters.placeholders.traits'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.goals') }}</label>
                    {!! Form::textarea('goals', $random->generate('goal'), ['placeholder' => trans('characters.placeholders.goals'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.fears') }}</label>
                    {!! Form::textarea('fears', $random->generate('fear'), ['placeholder' => trans('characters.placeholders.fears'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.mannerisms') }}</label>
                    {!! Form::textarea('mannerisms', $random->generate('mannerism'), ['placeholder' => trans('characters.placeholders.mannerisms'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.free') }}</label>
                    {!! Form::textarea('free', null, ['placeholder' => trans('characters.placeholders.free'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <hr>
                <div class="form-group">
                    {!! Form::hidden('is_personality_visible', 0) !!}
                    <label>{!! Form::checkbox('is_personality_visible', 1, (!empty($model) ? $model->is_personality_visible : 1)) !!}
                        {{ trans('characters.fields.is_personality_visible') }}
                    </label>
                    <p class="help-block">{{ trans('characters.hints.is_personality_visible') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <button class="btn btn-success">{{ trans('crud.save') }}</button>
        <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    </div>
</div>
