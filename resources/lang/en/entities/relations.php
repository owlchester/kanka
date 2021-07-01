<?php

return [
    'create'        => [
        'success'   => 'Relation :target added to :entity.',
        'title'     => 'New relation for :name',
    ],
    'destroy'       => [
        'success'   => 'Relation :target removed for :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Attitude',
        'connection'        => 'Connection',
        'is_star'           => 'Pinned',
        'relation'          => 'Relation',
        'target'            => 'Target',
        'target_relation'   => 'Target Relation',
        'two_way'           => 'Create mirror relation',
    ],
    'filters' => [
        'relations' => 'Relations',
        'related'   => 'Related',
        'mentions'  => 'Mentions',
        'submit'    => 'Show',
    ],
    'helper'        => 'Set up relations between entities with attitudes and visibility. Relations can also be pinned to the entity\'s menu.',
    'hints'         => [
        'attitude'          => 'This optional field can be used to define the default order relations appear in by descending order.',
        'mirrored'          => [
            'text'  => 'This relation is mirrored with :link.',
            'title' => 'Mirrored',
        ],
        'target_relation'   => 'The relation description on the target. Leave blank to use this relation\'s text.',
        'two_way'           => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
    ],
    'panels'        => [
        'connections'   => 'Connections',
    ],
    'placeholders'  => [
        'attitude'  => '-100 to 100, 100 being very positive',
        'relation'  => 'Rival, Best Friend, Sibling',
        'target'    => 'Choose an entity',
    ],
    'show'          => [
        'title' => 'Relations for :name',
    ],
    'teaser'        => 'Boost the campaign to get access to the relations explorer. Click to learn more about boosted campaigns.',
    'types'         => [
        'family_member'         => 'Family member',
        'organisation_member'   => 'Organisation Member',
    ],
    'update'        => [
        'success'   => 'Relation :target updated for :entity.',
        'title'     => 'Update relations for :name',
    ],
    'connections' => [
        'quest_element' => 'Quest element',
        'map_point' => 'Map point',
        'timeline_element' => 'Timeline element',
    ],
];
