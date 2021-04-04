<div class="form-group required">
    <label for="config-entity">
        {{ __('crud.fields.entity_type') }}
    </label>
    {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control recent-entity-type']) !!}
</div>

<div class="form-group recent-filters" style="@if (empty($model) || empty($model->conf('entity'))) display: none @else @endif">
    <label>{{ __('dashboard.widgets.recent.filters') }}</label>
    {!! Form::text('config[filters]', null, ['class' => 'form-control']) !!}
    <p class="help-block">{!! __('dashboard.widgets.recent.helpers.filters', ['link' => '<a href="' . route('helpers.widget-filters') . '" target="_blank"><i class="fas fa-external-link-alt"></i> ' . __('helpers.widget-filters.link') . '</a>']) !!}</p>
</div>

@include('dashboard.widgets.forms._tags')

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

@includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
