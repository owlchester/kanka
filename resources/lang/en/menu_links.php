<?php

return [
    'create'        => [
        'description'   => 'Create a new menu link',
        'success'       => 'Menu Link \':name\' created.',
        'title'         => 'New Menu Link',
    ],
    'destroy'       => [
        'success'   => 'Menu Link \':name\' removed.',
    ],
    'edit'          => [
        'description'   => 'Edit a menu item.',
        'success'       => 'Menu Link \':name\' updated.',
        'title'         => 'Menu Link :name',
    ],
    'fields'        => [
        'entity'    => 'Entity',
        'filters'   => 'Filters',
        'menu'      => 'Menu',
        'name'      => 'Name',
        'position'  => 'Position',
        'tab'       => 'Tab',
        'type'      => 'Entity Type',
    ],
    'helpers'       => [
        'entity'    => 'Set up this menu link to go directly to an entity. The :tab field controls which of the tabs is focused. The :menu field controls which subpage of the entity is opened.',
        'position'  => 'Use this field to control in which ascending order the links appear in the menu.',
        'type'      => 'Set up this menu link to go directly to a list of entities. To filter the results, copy parts of the url on the filtered entity list after the :? sign into the :filter field',
    ],
    'index'         => [
        'add'           => 'New Menu Link',
        'description'   => 'Manage the menu links of :name.',
        'header'        => 'Menu Link of :name',
        'title'         => 'Menu Links',
    ],
    'placeholders'  => [
        'entity'    => 'Choose an entity',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Menu subpage (use the last text of the url)',
        'name'      => 'Name of the menu link',
        'tab'       => 'entry, relations, notes',
    ],
    'show'          => [
        'description'   => 'A detailed view of a menu link',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Menu Link :name',
    ],
];
