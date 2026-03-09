<?php

return [
    'create'        => [
        'title' => 'New Quest',
    ],
    'elements'      => [
        'create'    => [
            'success'   => 'Element :entity added to the quest.',
            'title'     => 'New element for :name',
        ],
        'destroy'   => [
            'success'   => 'Element :entity removed.',
        ],
        'edit'      => [
            'success'   => 'Element :entity updated.',
            'title'     => 'Update element for :name',
        ],
        'fields'    => [
            'copy_entity_entry' => 'Use entity entry',
            'description'       => 'Description',
            'entity_or_name'    => 'Either select either an entry of the campaign, or give a name for this element.',
            'name'              => 'Name',
        ],
        'helpers'   => [
            'copy_entity_entry' => 'Display the linked entity\'s entry instead of the custom description.',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Copy elements attached to the quest',
        'date'          => 'Date',
        'element_role'  => 'Role',
        'instigator'    => 'Instigator',
        'is_completed'  => 'Completed',
        'status'        => 'Status',
        'location'      => 'Starting location',
        'role'          => 'Role',
    ],
    'helpers'       => [
        'is_completed'  => 'The quest is considered as completed.',
        'status'        => 'The quest\'s current status.',
    ],
    'hints'         => [
        'is_completed'  => 'This quest is completed.',
        'is_ongoing'    => 'This quest is ongoing.',
        'is_abandoned'  => 'This quest has been abandoned.',
    ],
    'status'        => [
        'not_started'   => 'Not Started',
        'ongoing'       => 'Ongoing',
        'completed'     => 'Completed',
        'abandoned'     => 'Abandoned',
    ],
    'lists'         => [
        'empty' => 'Create quests to record objectives, storylines, or character motivations.',
    ],
    'placeholders'  => [
        'date'      => 'Real world date for the quest',
        'entity'    => 'Name of an element from the quest',
        'location'  => 'The quest\'s starting location',
        'role'      => 'This entry\'s role in the quest',
        'type'      => 'Character Arc, Sidequest, Main',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Add an element',
        ],
        'tabs'      => [
            'elements'  => 'Elements',
        ],
    ],
];
