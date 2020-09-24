{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'character_id',
                (isset($model) && $model->character ? $model->character : null),
                App\Models\Character::class,
                true
            ) !!}
        </div>
        <div class="form-group">
            <label>{{ __('quests.fields.role') }}</label>
            {!! Form::text('role', null, ['placeholder' => __('quests.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('quests.characters.fields.description') }}</label>
            {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'description', 'name' => 'description']) !!}
        </div>

        <div class="form-group">
            <label>{{ __('calendars.fields.colour') }}</label>
            {!! Form::select('colour', FormCopy::colours(), null, ['class' => 'form-control']) !!}
        </div>

        @if (Auth::user()->isAdmin())
        <div class="form-group">
            {!! Form::hidden('is_private', 0) !!}
            <label>{!! Form::checkbox('is_private', 1, (isset($model) ? $model->is_private : CampaignLocalization::getCampaign()->entity_visibility)) !!}
                {{ __('crud.fields.is_private') }}
            </label>
            <p class="help-block">{{ __('crud.hints.is_private') }}</p>
        </div>
        @endif
    </div>
</div>

{!! Form::hidden('quest_id', $parent->id) !!}
