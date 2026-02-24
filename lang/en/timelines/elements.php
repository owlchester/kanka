<?php

return [
    'copy_mention'  => [
        'copy_with_name'    => 'Copy advanced mention with element name',
        'success'           => 'Advanced mention to element copied to the clipboard.',
    ],
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
        'use_entity_entry'  => 'Display the attached entry\'s entry below. This element\'s text will be displayed first if it is present.',
        'use_event_date'    => 'Use linked event\'s date.',
    ],
    'helpers'       => [
        'date'              => 'If the element is linked to an event entity, display the event\'s date.',
        'entity_is_private' => 'The element\'s entry is private.',
        'icon'              => 'Copy the CSS class of an icon from :fontawesome or :rpgawesome.',
        'is_collapsed'      => 'The element displays collapsed by default.',
    ],
    'placeholders'  => [
        'date'      => 'e.g. March 42nd or 1332-1337',
        'name'      => 'Required if no entry selected',
        'position'  => 'Position in the list of elements for the era. Leave blank to add to the end.',
    ],
];
