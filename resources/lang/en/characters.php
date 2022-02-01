<?php

return [
    'actions'       => [
        'add_appearance'    => 'Add an appearance',
        'add_organisation'  => 'Add an organisation',
        'add_personality'   => 'Add a personality',
    ],
    'conversations' => [
        'title' => 'Character :name Conversations',
    ],
    'create'        => [
        'success'   => 'Character \':name\' created.',
        'title'     => 'New Character',
    ],
    'destroy'       => [
        'success'   => 'Character \':name\' removed.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Dice rolls can be assigned to a character for in game usage.',
        'title' => 'Character :name Dice Rolls',
    ],
    'edit'          => [
        'success'   => 'Character \':name\' updated.',
        'title'     => 'Edit Character :name',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'families'                  => 'Families',
        'family'                    => 'Family',
        'image'                     => 'Image',
        'is_appearance_pinned'      => 'Pinned appearance',
        'is_dead'                   => 'Dead',
        'is_personality_visible'    => 'Personality visible',
        'is_personality_pinned'     => 'Pinned personality',
        'life'                      => 'Life',
        'location'                  => 'Location',
        'name'                      => 'Name',
        'physical'                  => 'Physical',
        'pronouns'                  => 'Pronouns',
        'race'                      => 'Race',
        'races'                     => 'Races',
        'relation'                  => 'Relation',
        'sex'                       => 'Gender',
        'title'                     => 'Title',
        'traits'                    => 'Traits',
        'type'                      => 'Type',
    ],
    'helpers'       => [
        'age'   => 'You can link this entity with a calendar of your campaign to automatically calculate their age instead. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'This character is dead',
        'is_personality_visible'    => 'Uncheck this option to hide the whole personality section from members outside of the :admin role.',
        'is_personality_pinned'          => 'If checked, the character\'s personality traits will appear below the entry on the overview page.',
        'is_appearance_pinned'          => 'If checked, the character\'s appearance traits will appear below the entry on the overview page.',
        'personality_not_visible'   => 'Personality traits of this character are currently only visible to Admin users.',
        'personality_visible'       => 'Personality traits of this character are visible to all.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'New Random Character',
        ],
        'add'       => 'New Character',
        'header'    => 'Characters in :name',
        'title'     => 'Characters',
    ],
    'items'         => [
        'hint'  => 'Items can be assigned to characters and will be displayed here.',
        'title' => 'Character :name Items',
    ],
    'journals'      => [
        'title' => 'Character :name Journals',
    ],
    'maps'          => [
        'title' => 'Character :name Relation Map',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Add organisation',
        ],
        'create'        => [
            'success'   => 'Character added to organisation.',
            'title'     => 'New Organisation for :name',
        ],
        'destroy'       => [
            'success'   => 'Character organisation removed.',
        ],
        'edit'          => [
            'success'   => 'Character organisation updated.',
            'title'     => 'Update Organisation for :name',
        ],
        'fields'        => [
            'organisation'  => 'Organisation',
            'role'          => 'Role',
        ],
        'hint'          => 'Characters can be part of many organisations, representing who they work for or what secret society they are part of.',
        'placeholders'  => [
            'organisation'  => 'Choose an organisation...',
        ],
        'title'         => 'Character :name Organisations',
    ],
    'placeholders'  => [
        'age'               => 'Age',
        'appearance_entry'  => 'Description',
        'appearance_name'   => 'Hair, Eyes, Skin, Height',
        'family'            => 'Select a character',
        'image'             => 'Image',
        'location'          => 'Select a location',
        'name'              => 'Name',
        'personality_entry' => 'Details',
        'personality_name'  => 'Goals, Mannerisms, Fears, Bonds',
        'physical'          => 'Physical',
        'pronouns'          => 'He/Him, She/Her, They/Their',
        'race'              => 'Race',
        'races'             => 'Choose races',
        'sex'               => 'Gender',
        'title'             => 'Title',
        'traits'            => 'Traits',
        'type'              => 'NPC, Player Character, Deity',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Quests that the character is a quest giver of.',
            'quest_member'  => 'Quests that the character is a member of.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Appearance',
        'general'       => 'General information',
        'personality'   => 'Personality',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'Relation Map',
            'organisations' => 'Organisations',
            'personality'   => 'Personality',
        ],
        'title' => 'Character :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'You aren\'t allowed to edit personality traits on this character.',
    ],
];
