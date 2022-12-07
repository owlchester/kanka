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
        'use_entity_entry'  => 'Display the attached entity\'s entry below. This element\'s text will be displayed first if it is present.',
        'use_event_date'    => 'Use linked Event\'s date.',
    ],
    'helpers'       => [
        'entity_is_private' => 'The element\'s entity is private.',
        'icon'              => 'Copy the CSS class of an icon from :fontawesome or :rpgawesome.',
        'is_collapsed'      => 'The element displays collapsed by default.',
        'date'              => 'If the element is linked to an event entity, display the event\'s date.'
    ],
    'placeholders'  => [
        'date'      => 'e.g. March 42nd or 1332-1337',
        'name'      => 'Required if no entity selected',
        'position'  => 'Position in the list of elements for the era. Leave blank to add to the end.',
    ],
    'warning'       => [
        'editing'   => [
            'description'   => 'Looks like someone else is currently editing this timeline element! Do you want to go back or ignore this warning, at the risk of losing data? Members currently editing this timeline element:',
        ],
    ],
];
