{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'location_id',
                (isset($model) && $model->location ? $model->location : null),
                App\Models\Location::class,
                true
            ) !!}
        </div>
        <div class="form-group">
            <label>{{ __('quests.fields.role') }}</label>
            {!! Form::text('role', null, ['placeholder' => __('quests.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('quests.locations.fields.description') }}</label>
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
