@inject('formService', 'App\Services\FormService')

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
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('items.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('items.fields.type') }}</label>
                    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('items.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                @if ($campaign->enabled('locations'))
                <div class="form-group">
                    <label>{{ trans('items.fields.location') }}</label>
                    <div class="input-group input-group-sm">
                        {!! Form::select('location_id', (isset($model) && $model->location ? [$model->location_id => $model->location->name] : $formService->prefillSelect('location', $source)),
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
                        {!! Form::select('character_id', (isset($model) && $model->character ? [$model->character_id => $model->character->name] : $formService->prefillSelect('character', $source)),
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
                    <label>{!! Form::checkbox('is_private', 1, $formService->prefill('is_private', $source)) !!}
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
                @include('cruds.fields.image')
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
                    {!! Form::textarea('description', $formService->prefill('description', $source), ['class' => 'form-control html-editor', 'id' => 'description']) !!}
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
                    {!! Form::textarea('history', $formService->prefill('history', $source), ['class' => 'form-control html-editor', 'id' => 'history']) !!}
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
