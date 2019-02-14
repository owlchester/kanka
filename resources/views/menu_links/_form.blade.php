@inject('formService', 'App\Services\FormService')
@inject('entityService', 'App\Services\EntityService')
@inject('campaign', 'App\Services\CampaignService')
<?php /**
 * @var \App\Models\MenuLink $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\FormService $formService
 * @var \App\Services\CampaignService $campaign
 */

$tabs = [
    '' => __('crud.tabs.default'),
    'relations' => __('crud.tabs.relations'),
    'notes' => __('crud.tabs.notes'),
    'calendars' => __('crud.tabs.calendars'),
    'attribute' => __('crud.tabs.attributes'),
];
$entityTypes = ['' => ''];
foreach ($entityService->getEnabledEntities($campaign->campaign()) as $entity) {
    $entityTypes[$entity] = __('entities.' . str_plural($entity));
}
$tab = empty($model) || old('entity_id') || $model->entity_id ? 'entity' : 'type';
?>

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('menu_links.fields.name') }}</label>
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('menu_links.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="{{ $tab == 'entity' ? 'active' : null }}">
                            <a href="#tab_entity" data-toggle="tab">{{ __('menu_links.fields.entity') }}</a>
                        </li>
                        <li class="{{ $tab == 'type' ? 'active' : null }}">
                            <a href="#tab_type" data-toggle="tab">{{ __('menu_links.fields.type') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane {{ $tab == 'entity' ? 'active' : null }}" id="tab_entity">
                            <div class="form-group required">
                                {!! Form::select2(
                                    'entity_id',
                                    (!empty($model) && $model->entity? $model->entity: null),
                                    App\Models\Entity::class,
                                    false,
                                    'menu_links.fields.entity',
                                    'search.relations',
                                    'menu_links.placeholders.entity'
                                ) !!}
                            </div>

                            <div class="form-group">
                                <label>{{ trans('menu_links.fields.tab') }}</label>
                                {!! Form::select('tab', $tabs, null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label>{{ trans('menu_links.fields.menu') }}</label>
                                {!! Form::text('menu', $formService->prefill('tab', $source), ['placeholder' => trans('menu_links.placeholders.menu'), 'class' => 'form-control', 'maxlength' => 20]) !!}
                            </div>
                        </div>
                        <div class="tab-pane {{ $tab == 'type' ? 'active' : null }}" id="tab_type">

                            <div class="form-group">
                                <label>{{ trans('menu_links.fields.type') }}</label>
                                {!! Form::select('type', $entityTypes, $formService->prefill('type', $source), ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label>{{ trans('menu_links.fields.filters') }}</label>
                                {!! Form::text('filters', $formService->prefill('filters', $source), ['placeholder' => trans('menu_links.placeholders.filters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @include('cruds.fields.private')
            </div>
        </div>
    </div>
</div>

@include('cruds.fields.save')
