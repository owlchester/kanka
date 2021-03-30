<div class="form-group required">
    <label for="config-entity">
        {{ __('crud.fields.entity') }}
    </label>
    {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : null,
                'enableNew' => false
            ]
        ) !!}
    <p class="help-block">{{ __('dashboard.widgets.recent.tags') }}</p>
    <input type="hidden" name="save_tags" value="1" />
</div>

<div class="form-group">
    <label>{{ __('dashboard.widgets.recent.filters') }}</label>
    {!! Form::text('config[filters]', null, ['class' => 'form-control']) !!}
    <p class="help-block">{!! __('dashboard.widgets.recent.helpers.filters', ['link' => '<a href="' . route('helpers.widget-filters') . '" target="_blank"><i class="fas fa-external-link-alt"></i> ' . __('helpers.widget-filters.link') . '</a>']) !!}</p>
</div>

<div class="form-group">
    {!! Form::hidden('config[singular]', 0) !!}
    <div class="checkbox">
        <label>
            {!! Form::checkbox('config[singular]', 1, (!empty($model) ? $model->conf('singular') : null)) !!}

            {{ __('dashboard.widgets.recent.singular') }}
        </label>
    </div>
    <p class="help-block">
        {{ __('dashboard.widgets.recent.help') }}
    </p>
</div>


<div class="row">
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._name')
    </div>
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._width')
    </div>
</div>
