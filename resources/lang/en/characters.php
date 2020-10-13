<?php

return [
    'actions'       => [
        'add_appearance'    => 'Add an appearance',
        'add_organisation'  => 'Add an organisation',
        'add_personality'   => 'Add a personality',
    ],
    'conversations' => [
        'description'   => 'Conversations the character is participating in.',
        'title'         => 'Character :name Conversations',
    ],
    'create'        => [
        'description'   => 'Create a new character',
        'success'       => 'Character \':name\' created.',
        'title'         => 'New Character',
    ],
    'destroy'       => [
        'success'   => 'Character \':name\' removed.',
    ],
    'dice_rolls'    => [
        'description'   => 'Dice rolls assigned to the character.',
        'hint'          => 'Dice rolls can be assigned to a character for in game usage.',
        'title'         => 'Character :name Dice Rolls',
    ],
    'edit'          => [
        'description'   => 'Edit a character',
        'success'       => 'Character \':name\' updated.',
        'title'         => 'Edit Character :name',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'family'                    => 'Family',
        'image'                     => 'Image',
        'is_dead'                   => 'Dead',
        'is_personality_visible'    => 'Personality visible',
        'life'                      => 'Life',
        'location'                  => 'Location',
        'name'                      => 'Name',
        'physical'                  => 'Physical',
        'race'                      => 'Race',
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
        'is_personality_visible'    => 'Uncheck this option to hide the whole personality section from non Admin users.',
        'personality_visible'       => 'Personality traits of this character are visible to all.',
        'personality_not_visible'   => 'Personality traits of this character are currently only visible to Admin users.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'New Random Character',
        ],
        'add'           => 'New Character',
        'description'   => 'Manage the characters of :name.',
        'header'        => 'Characters in :name',
        'title'         => 'Characters',
    ],
    'items'         => [
        'description'   => 'Items held or owned by the character.',
        'hint'          => 'Items can be assigned to characters and will be displayed here.',
        'title'         => 'Character :name Items',
    ],
    'journals'      => [
        'description'   => 'Journals the character is an author of.',
        'title'         => 'Character :name Journals',
    ],
    'maps'          => [
        'description'   => 'Relation map for a character.',
        'title'         => 'Character :name Relation Map',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Add organisation',
        ],
        'create'        => [
            'description'   => 'Associate an organisation to a character',
            'success'       => 'Character added to organisation.',
            'title'         => 'New Organisation for :name',
        ],
        'description'   => 'Organisations the character is a part of.',
        'destroy'       => [
            'success'   => 'Character organisation removed.',
        ],
        'edit'          => [
            'description'   => 'Update a character\'s organisation',
            'success'       => 'Character organisation updated.',
            'title'         => 'Update Organisation for :name',
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
        'race'              => 'Race',
        'sex'               => 'Gender',
        'title'             => 'Title',
        'traits'            => 'Traits',
        'type'              => 'NPC, Player Character, Deity',
    ],
    'quests'        => [
        'description'   => 'Quests a character is a part of.',
        'helpers'       => [
            'quest_giver'   => 'Quests that the character is a quest giver of.',
            'quest_member'  => 'Quests that the character is a member of.',
        ],
        'title'         => 'Character :name Quests',
    ],
    'sections'      => [
        'appearance'    => 'Appearance',
        'general'       => 'General information',
        'personality'   => 'Personality',
    ],
    'show'          => [
        'description'   => 'A detailed view of a character',
        'tabs'          => [
            'conversations' => 'Conversations',
            'dice_rolls'    => 'Dice Rolls',
            'items'         => 'Items',
            'journals'      => 'Journals',
            'map'           => 'Relation Map',
            'organisations' => 'Organisations',
            'personality'   => 'Personality',
            'quests'        => 'Quests',
        ],
        'title'         => 'Character :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'You aren\'t allowed to edit personality traits on this character.',
    ],
];
