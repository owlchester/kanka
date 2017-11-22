{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('quests.locations.fields.location') }}</label>
            {!! Form::select('location_id', (!empty($model) && $model->location? [$model->location->id => $model->location->name] : []), null,
            ['id' => 'location_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
             'data-url' => route('locations.find'), 'data-placeholder' => trans('organisations.members.placeholders.location')]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('quests.locations.fields.description') }}</label>
            {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('is_private', 0) !!}
            <label>{!! Form::checkbox('is_private') !!}
                {{ trans('quests.locations.fields.is_private') }}
            </label>
            <p class="help-block">{{ trans('quests.locations.hints.is_private') }}</p>
        </div>
    </div>
</div>

{!! Form::hidden('quest_id', $parent->id) !!}