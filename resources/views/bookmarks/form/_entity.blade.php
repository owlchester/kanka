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
<x-grid type="1/1">
    <x-helper>
            {!! __('bookmarks.helpers.entity', [
            'menu' => '<code>' . __('bookmarks.fields.menu') . '</code>',
            ]) !!}
    </x-helper>

    <x-grid>
        @include('cruds.fields.entity', [
            'name' => 'entity_id',
            'required' => true,
            'preset' => !empty($model) && $model->target ? $model->target : null,
            'label' => __('bookmarks.fields.entity'),
        ])

        <x-forms.field field="menu" :label="__('bookmarks.fields.menu')">
            {!! Form::select('menu', $menus, null, ['class' => '', 'id' => 'entity-selector']) !!}
        </x-forms.field>

        <x-forms.field field="filter" :label="__('bookmarks.fields.filters')" :hidden="true">
            {!! Form::text('options[subview_filter]', !isset($model->options['subview_filter']) ? '' : $model->options['subview_filter'], ['placeholder' => 'k=name&s=desc', 'class' => '', 'maxlength' => 191]) !!}
        </x-forms.field>
    </x-grid>
</x-grid>
