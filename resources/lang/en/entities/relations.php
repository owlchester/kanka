<?php

return [
    'actions'       => [
        'mode-map'      => 'Relation exploration tool',
        'mode-table'    => 'Table of relations and connections',
    ],
    'bulk' => [
        'delete' => 'Deleted :count relation.|Deleted :count relations.',
        'update' => 'Updated :count relation.|Updated :count relations.',
    ],
    'connections'   => [
        'map_point'         => 'Map point',
        'mention'           => 'Mention',
        'quest_element'     => 'Quest element',
        'timeline_element'  => 'Timeline element',
    ],
    'create'        => [
        'success'   => 'Relation :target added to :entity.',
        'title'     => 'New relation for :name',
        'new_title' => 'New relation',
    ],
    'destroy'       => [
        'success'   => 'Relation :target removed for :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Attitude',
        'connection'        => 'Connection',
        'is_star'           => 'Pinned',
        'relation'          => 'Relation',
        'owner'             => 'Owner',
        'target'            => 'Target',
        'target_relation'   => 'Target Relation',
        'two_way'           => 'Create mirror relation',
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
    'index'         => [
        'title' => 'Relations',
        'add' => 'New relation',
    ],
    'options'       => [
        'mentions'  => 'Relations + related + mentions',
        'related'   => 'Relations + related',
        'relations' => 'Relations',
        'show'      => 'Show',
    ],
    'panels'        => [
        'related'   => 'Related',
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
];
