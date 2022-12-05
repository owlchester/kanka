<?php

$tabs = [
        //'' => __('crud.tabs.story'),
        'notes' => __('entities.notes'),
        'calendars' => __('entities.calendars'),
        'attribute' => __('crud.tabs.attributes'),
];
$menus = [
        'abilities' => __('crud.tabs.abilities'),
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
            'families' => __('families.show.tabs.families')
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
            'quest_elements' => __('quests.show.tabs.elements')
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

<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            {!! Form::select2(
                'entity_id',
                (!empty($model) && $model->target ? $model->target : null),
                App\Models\Entity::class,
                false,
                'menu_links.fields.entity',
                'search.entities-with-relations',
                'menu_links.placeholders.entity'
            ) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('menu_links.fields.menu') }}</label>
            {!! Form::select('menu', $menus, null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
