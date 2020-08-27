<div class="form-group required">
    {!! Form::select2(
        'entity_id',
        !empty($model) && $model->entity ? $model->entity : null,
        App\Models\Entity::class,
        false,
        'crud.fields.entity',
        'search.entities-with-relations'
    ) !!}
</div>


<div class="form-group">
    {!! Form::hidden('config[full]', 0) !!}
    <label>
        {{ __('dashboard.widgets.recent.full') }}
    </label>
    <div class="checkbox">
        <label>
            {!! Form::checkbox('config[full]', 1, (!empty($model) ? $model->conf('full') : null), ['id' => 'config-full']) !!}
            {{ __('dashboard.widgets.recent.helpers.full') }}
        </label>
    </div>
</div>

@if($campaign->campaign()->boosted())

    <div class="form-group">
        {!! Form::hidden('config[entity-header]', 0) !!}
        <label>
            {{ __('dashboard.widgets.recent.entity-header') }}
        </label>
        <div class="checkbox">
            <label>
                {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header']) !!}
                {{ __('dashboard.widgets.recent.helpers.entity-header') }}
            </label>
        </div>
    </div>

@endif
