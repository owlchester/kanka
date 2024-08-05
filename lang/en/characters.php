<?php

return [
    'actions'       => [
        'add_appearance'    => 'Add an appearance',
        'add_personality'   => 'Add a personality',
    ],
    'create'        => [
        'title' => 'New Character',
    ],
    'families'      => [
        'reorder'   => [
            'success'   => 'Character families updated successfully.',
        ],
        'title'     => 'Manage families of :name',
    ],
    'fields'        => [
        'age'                       => 'Age',
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
        'is_appearance_pinned'      => 'Display the appearance traits on the overview page.',
        'is_dead'                   => 'This character is dead.',
        'is_personality_pinned'     => 'Display the personality traits on the overview page.',
        'is_personality_visible'    => 'The personality traits are visible to all, not only to members of the :admin role.',
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
        'create'    => [
            'success'   => ':character added to :organisation.',
            'title'     => 'Membership',
        ],
        'destroy'   => [
            'success'   => 'Membership removed.',
        ],
        'edit'      => [
            'success'   => 'Membership updated.',
            'title'     => 'Update membership :name',
        ],
        'fields'    => [
            'role'  => 'Role',
        ],
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
    'races'         => [
        'reorder'   => [
            'success'   => 'Character races updated successfully',
        ],
        'title'     => 'Manage races of :name',
    ],
    'sections'      => [
        'appearance'    => 'Appearance',
        'personality'   => 'Personality',
    ],
    'warnings'      => [
        'personality_hidden'    => 'You aren\'t allowed to edit personality traits on this character.',
    ],
];
