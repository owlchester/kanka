{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('quests.characters.fields.character') }}</label>
            {!! Form::select('character_id', (!empty($model) && $model->character? [$model->character->id => $model->character->name] : []), null,
             ['id' => 'character_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
             'data-url' => route('characters.find'), 'data-placeholder' => trans('crud.placeholders.character')]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('quests.characters.fields.description') }}</label>
            {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
        </div>

        @if (Auth::user()->isAdmin())
        <div class="form-group">
            {!! Form::hidden('is_private', 0) !!}
            <label>{!! Form::checkbox('is_private') !!}
                {{ trans('crud.fields.is_private') }}
            </label>
            <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
        </div>
        @endif
    </div>
</div>

{!! Form::hidden('quest_id', $parent->id) !!}