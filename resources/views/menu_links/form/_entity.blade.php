<?php

$tabs = [
        //'' => __('crud.tabs.story'),
        'notes' => __('entities.notes'),
        'calendars' => __('entities.calendars'),
        'attribute' => __('crud.tabs.attributes'),
];
$menus = [
        'abilities' => __('crud.tabs.abilities'),
        'attributes' => __('crud.tabs.attributes'),
        'assets' => __('crud.tabs.assets'),
        'reminders' => __('crud.tabs.reminders'),
        'organisations' => __('entities.organisations')  . ' (' . __('entities.characters') . ', ' . __('entities.organisations') . ')',
        __('entities.maps') => [
            'explore' => __('maps.actions.explore'),
            'maps' => __('entities.maps'),
        ],
        __('entities.tags') => [
            //'children' => __('tags.show.tabs.children'),
            'tags' => __('entities.tags'),
        ],
        __('entities.locations') => [
            'map' => __('entities.map') . ' (' . __('crud.legacy') . ')',
            'characters' => __('entities.characters'),
            'locations' => __('entities.locations'),
        ],
        __('entities.families') => [
            'families' => __('entities.families')
        ],
        __('entities.items') => [
            'inventories' => __('items.show.tabs.inventories')
        ],
        __('entities.organisations') => [
            'organisations' => __('entities.organisations')
        ],
        __('entities.races') => [
            'races' => __('entities.races')
        ],
        __('entities.journals') => [
            'journals' => __('entities.journals')
        ],
        __('entities.quests') => [
            'quest_elements.index' => __('quests.show.tabs.elements')
        ],

        'inventory' => __('crud.tabs.inventory'),
        'relations' => __('crud.tabs.connections'),
];
asort($menus);
$menus = array_merge(['' => __('crud.tabs.story')], $menus);
?>
<p class="help-block">{!! __('menu_links.helpers.entity', [
    'menu' => '<code>' . __('menu_links.fields.menu') . '</code>',
    ]) !!}</p>

<x-grid>
    @include('cruds.fields.entity', [
        'name' => 'entity_id',
        'required' => true,
        'preset' => !empty($model) && $model->target ? $model->target : null,
        'label' => __('menu_links.fields.entity'),
    ])

    <div class="form-group">
        <label>{{ __('menu_links.fields.menu') }}</label>
        {!! Form::select('menu', $menus, null, ['class' => 'form-control', 'id' => 'entity-selector']) !!}
    </div>

    <div class="form-group" id="filter-subform" style="display: none">
        <label>{{ __('menu_links.fields.filters') }}</label>
        {!! Form::text('options[subview_filter]', !isset($model->options['subview_filter']) ? '' : $model->options['subview_filter'], ['placeholder' => 'k=name&s=desc', 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>
</x-grid>
