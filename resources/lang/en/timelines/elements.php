<?php

return [
    'create'        => [
        'success'   => 'Element added to the timeline.',
        'title'     => 'New Timeline Element',
    ],
    'delete'        => [
        'success'   => 'Element :name removed.',
    ],
    'edit'          => [
        'success'   => 'Element updated.',
        'title'     => 'Edit Timeline Element',
    ],
    'fields'        => [
        'date'              => 'Date',
        'era'               => 'Era',
        'icon'              => 'Icon',
        'use_entity_entry'  => 'Display the attached entity\'s entry below. This element\'s text will be displayed first if it is present.',
    ],
    'helpers'       => [
        'entity_is_private' => 'The element\'s entity is private.',
        'icon'              => 'Copy the CSS class of an icon from :fontawesome or :rpgawesome.',
        'is_collapsed'      => 'The element displays collapsed by default.',
    ],
    'placeholders'  => [
        'date'      => 'e.g. March 42nd or 1332-1337',
        'name'      => 'Required if no entity selected',
        'position'  => 'Position in the list of elements for the era. Leave blank to add to the end.',
    ],
];
