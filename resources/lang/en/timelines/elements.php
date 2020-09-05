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
        'date'  => 'Date',
        'era'   => 'Era',
        'icon'  => 'Icon',
    ],
    'helpers'       => [
        'icon'  => 'Copy the HTML of an icon from :fontawesome or :rpgawesome.',
    ],
    'placeholders'  => [
        'date'      => 'e.g. March 42nd or 1332-1337',
        'name'      => 'Required if no entity selected',
        'position'  => 'Position in the list of elements for the era. Leave blank to add to the end.',
    ],
];
