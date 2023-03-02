<?php

return [
    'actions'           => [
        'customise' => 'Customise sidebar',
    ],
    'create'            => [
        'title' => 'New Quick Link',
    ],
    'edit'              => [
        'title' => 'Quick Link :name',
    ],
    'fields'            => [
        'active'            => 'Active',
        'dashboard'         => 'Dashboard',
        'default_dashboard' => 'Default dashboard',
        'entity'            => 'Entity',
        'filters'           => 'Filters',
        'is_nested'         => 'Nested',
        'menu'              => 'Subpage',
        'position'          => 'Position',
        'random'            => 'Random',
        'random_type'       => 'Random Entity Type',
        'selector'          => 'Quick Link Configuration',
        'type'              => 'Entity List',
    ],
    'helpers'           => [
        'active'            => 'Inactive quick links won\'t appear in the sidebar.',
        'dashboard'         => 'Have the quick link target one of the campaign\'s custom dashboards.',
        'default_dashboard' => 'Link to the campaign\'s default dashboard instead. A custom dashboard still needs to be selected.',
        'entity'            => 'Set up this quick link to go directly to an entity. The :menu field controls which subpage of the entity is opened.',
        'position'          => 'Use this field to control in which ascending order the links appear in the menu.',
        'random'            => 'Use this field to have a quick link pointing to a random entity. You can filter the link to only go to a specific entity type.',
        'selector'          => 'Configure where this quick link goes when a user clicks on it in the sidebar.',
        'type'              => 'Set up this quick link to go directly to a list of entities. To filter the results, copy parts of the url on the filtered entity list after the :? sign into the :filter field.',
    ],
    'placeholders'      => [
        'entity'    => 'Choose an entity',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Menu subpage (use the last text of the url)',
        'name'      => 'Name of the quick link',
        'tab'       => '(deprecated)',
    ],
    'random_no_entity'  => 'No random entity found.',
    'random_types'      => [
        'any'   => 'Any entity',
    ],
    'reorder'           => [
        'success'   => 'Quick links reordered.',
        'title'     => 'Reorder quick links',
    ],
    'visibilities'      => [
        'is_active' => 'Show the quick link in the sidebar',
    ],
];
