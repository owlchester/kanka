<?php

$tabs = [
        '' => __('crud.tabs.default'),
        'notes' => __('crud.tabs.notes'),
        'calendars' => __('crud.tabs.calendars'),
        'attribute' => __('crud.tabs.attributes'),
];
$menus = [
        'abilities' => __('crud.tabs.abilities'),
        'all-members' => __('families.show.tabs.all_members') . ' (' . __('entities.organisations') . ')',
        'locations' => __('locations.show.tabs.locations') . ' (' . __('entities.locations') . ')',
        'organisations' => __('characters.show.tabs.organisations')  . ' (' . __('entities.characters') . ', ' . __('entities.organisations') . ')',
        'explore' => __('maps.actions.explore') . ' (' . __('entities.maps') . ')',
        'quests' => __('characters.show.tabs.quests'),
        'tags' => __('tags.show.tabs.tags') . ' (' . __('entities.tags') . ')',
        'members' => __('families.show.tabs.members') . ' (' . __('entities.families') . ', ' . __('entities.organisations'). ')',
        'map_points' => __('crud.tabs.map-points'),
        'map' => __('locations.show.tabs.map') . ' (' . __('entities.locations') . ')',
        'inventories' => __('items.show.tabs.inventories'),
        'children' => __('tags.show.tabs.children') . ' (' . __('entities.tags') . ')',
        'inventory' => __('crud.tabs.inventory'),
        'relations' => __('crud.tabs.relations'),
];
asort($menus);
$menus = array_merge(['' => ''], $menus);
?>
<p class="help-block">{!! __('menu_links.helpers.entity', [
    'tab' => '<code>' . __('menu_links.fields.tab') . '</code>',
    'menu' => '<code>' . __('menu_links.fields.menu') . '</code>',
    ]) !!}</p>
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

<div class="form-group">
    <label>{{ trans('menu_links.fields.tab') }}</label>
    {!! Form::select('tab', $tabs, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>{{ trans('menu_links.fields.menu') }}</label>
    {!! Form::select('menu', $menus, null, ['class' => 'form-control']) !!}
</div>
