{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('items.fields.name') }}</label>
                    {!! Form::text('name', null, ['placeholder' => trans('items.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('items.fields.type') }}</label>
                    {!! Form::text('type', null, ['placeholder' => trans('items.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                @if ($campaign->enabled('locations'))
                <div class="form-group">
                    <label>{{ trans('items.fields.location') }}</label>
                    <div class="input-group input-group-sm">
                        {!! Form::select('location_id', (isset($model) && $model->location ? [$model->location_id => $model->location->name] : []),
                        null, ['id' => 'location_id', 'class' => 'form-control select2', 'style' => 'width: 100%', 'data-url' => route('locations.find'), 'data-placeholder' => trans('items.placeholders.location')]) !!}
                        <div class="input-group-btn">
                            <a class="btn btn-tab-form new-entity-selector" style="" data-toggle="modal" data-target="#new-entity-modal" data-parent="location_id" data-entity="locations">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @if ($campaign->enabled('characters'))
                <div class="form-group">
                    <label>{{ trans('items.fields.character') }}</label>
                    <div class="input-group input-group-sm">
                        {!! Form::select('character_id', (isset($model) && $model->character ? [$model->character_id => $model->character->name] : []),
                        null, ['id' => 'character_id', 'class' => 'form-control select2', 'style' => 'width: 100%', 'data-url' => route('characters.find'), 'data-placeholder' => trans('items.placeholders.character')]) !!}
                        <div class="input-group-btn">
                            <a class="btn btn-tab-form new-entity-selector" style="" data-toggle="modal" data-target="#new-entity-modal" data-parent="character_id" data-entity="characters">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <hr />

                <div class="form-group">
                    {!! Form::hidden('is_private', 0) !!}
                    <label>{!! Form::checkbox('is_private') !!}
                        {{ trans('crud.fields.is_private') }}
                    </label>
                    <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.appearance') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('items.fields.image') }}</label>

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
                <h4>{{ trans('crud.panels.description') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('items.fields.description') }}</label>
                    {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
                </div>
                <div class="form-group">
                    <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.history') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('items.fields.history') }}</label>
                    {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
                </div>
                <div class="form-group">
                    <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
