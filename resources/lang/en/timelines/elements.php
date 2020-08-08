<?php

return [
    'create'        => [
        'success'   => 'Element added to the timeline.',
        'title'     => 'New Timeline Element',
    ],
    'edit'          => [
        'success'   => 'Element updated.',
        'title'     => 'Edit Timeline Element',
    ],
    'fields' => [
        'era' => 'Era',
        'date' => 'Date',
        'icon' => 'Icon',
    ],
    'helpers' => [
        'icon'   => 'Copy the HTML of an icon from :fontawesome or :rpgawesome.',
    ],
    'placeholders' => [
        'name' => 'Required if no entity selected',
        'date' => 'e.g. March 42nd or 1332-1337',
        'position' => 'Position in the list of elements for the era. Leave blank to add to the end.',
    ],
];
