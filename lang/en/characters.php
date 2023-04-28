<?php

return [
    'actions'       => [
        'add_appearance'    => 'Add an appearance',
        'add_organisation'  => 'Add an organisation',
        'add_personality'   => 'Add a personality',
    ],
    'create'        => [
        'title' => 'New Character',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'families'                  => 'Families',
        'is_appearance_pinned'      => 'Pinned appearance',
        'is_dead'                   => 'Dead',
        'is_personality_pinned'     => 'Pinned personality',
        'is_personality_visible'    => 'Personality visible',
        'life'                      => 'Life',
        'physical'                  => 'Physical',
        'pronouns'                  => 'Pronouns',
        'sex'                       => 'Gender',
        'title'                     => 'Title',
        'traits'                    => 'Traits',
    ],
    'helpers'       => [
        'age'   => 'You can link this entity with a calendar of your campaign to automatically calculate their age instead. :more.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'If checked, the character\'s appearance traits will appear below the entry on the overview page.',
        'is_dead'                   => 'This character is dead',
        'is_personality_pinned'     => 'If checked, the character\'s personality traits will appear below the entry on the overview page.',
        'is_personality_visible'    => 'Uncheck this option to hide the whole personality section from members outside of the :admin role.',
        'personality_not_visible'   => 'Personality traits of this character are currently only visible to Admin users.',
        'personality_visible'       => 'Personality traits of this character are visible to all.',
    ],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Appearance description',
            'name'  => 'Appearance name',
        ],
        'personality'   => [
            'entry' => 'Personality trait description',
            'name'  => 'Personality trait name',
        ],
    ],
    'organisations' => [
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
            'role'          => 'Role',
        ],
        'hint'          => 'Characters can be part of many organisations, representing who they work for or what secret society they are part of.',
    ],
    'placeholders'  => [
        'age'               => 'Age',
        'appearance_entry'  => 'Description',
        'appearance_name'   => 'Hair, Eyes, Skin, Height',
        'name'              => 'Name of the character',
        'personality_entry' => 'Details',
        'personality_name'  => 'Goals, Mannerisms, Fears, Bonds',
        'physical'          => 'Physical',
        'pronouns'          => 'He/Him, She/Her, They/Them',
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
        'personality'   => 'Personality',
    ],
    'warnings'      => [
        'personality_hidden'    => 'You aren\'t allowed to edit personality traits on this character.',
    ],
];
