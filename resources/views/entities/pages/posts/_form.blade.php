<?php
/**
 * @var \App\Models\EntityNotePermission $perm
 */
$permissions = [
    0 => __('crud.view'),
    1 => __('crud.edit'),
    2 => __('crud.permissions.actions.bulk.deny')
];
$defaultCollapsed = null;
if (!isset($model) && !empty($campaign->ui_settings['post_collapsed'])) {
    $defaultCollapsed = 1;
}

$options = $entity->postPositionOptions(!empty($model->position) ? $model->position : null);
$last = array_key_last($options);

?>
<div class="nav-tabs-custom">
    <div class="pull-right">
        @include('entities.pages.posts._save-options')
    </div>
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#form-entry" title="{{ __('crud.fields.entry') }}">
                {{ __('crud.fields.entry') }}
            </a>
        </li>
       @can('permission', $entity->child)
        <li class="">
            <a href="#form-permissions" title="{{ __('entities/notes.show.advanced') }}">
                {{ __('entities/notes.show.advanced') }}
            </a>
        </li>
       @endcan
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="form-entry">
            <div class="form-group required">
                {!! Form::text('name', null, ['placeholder' => __('entities/notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'data-live-disabled' => '1', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
                <div class="text-right">
                    <a href="//docs.kanka.io/en/latest/features/mentions.html" target="_blank" title="{{ __('helpers.link.description') }}">
                        {{ __('crud.helpers.linking') }} <i class="fa-solid fa-question-circle"></i>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <input type="hidden" name="location_id" value="" />
                    @include('cruds.fields.location', ['from' => null])
                </div>
                <div class="col-md-6 col-lg-4">
                    @include('cruds.fields.visibility_id')
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="config[class]">
                            {{ __('dashboard.widgets.fields.class') }}
                            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.helpers.class') }}"></i>
                        </label>
                        {!! Form::text('settings[class]', null, ['class' => 'form-control', 'id' => 'config[class]', 'disabled' => !$campaign->boosted() ? 'disabled' : null]) !!}
                        <p class="help-block visible-xs visible-sm">
                            {{ __('dashboard.widgets.helpers.class') }}
                        </p>
                        @includeWhen(!$campaign->boosted(), 'entities.pages.posts._boosted')
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    @php
                        $collapsedOptions = [
                            0 => __('entities/notes.collapsed.open'),
                            1 => __('entities/notes.collapsed.closed')
                        ];
                    @endphp
                    <div class="form-group">
                        <label>
                            {{ __('entities/notes.fields.display') }}
                        </label>
                        {!! Form::select('settings[collapsed]', $collapsedOptions, $defaultCollapsed, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>{{ __('crud.fields.position') }}</label>
            {!! Form::select('position', $options, (!empty($model->position) ? $model->position : $last), ['class' => 'form-control']) !!}
        </div>

        @includeWhen(auth()->user()->can('permission', $entity->child), 'entities.pages.posts._permissions')
    </div>
</div>

{!! Form::hidden('entity_id', $entity->id) !!}
