<?php

return [
    'actions'       => [
        'mode-map'      => 'Relation exploration tool',
        'mode-table'    => 'Table of relations and connections',
    ],
    'bulk'          => [
        'delete'    => '{1} Deleted :count relation.|[2,*] Deleted :count relations.',
        'success'   => [
            'editing'           => '{1} :count relation was updated.|[2,*] :count relation were updated.',
            'editing_partial'   => '{1} :count/:total relation was updated.|[2,*] :count/:total relation were updated.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Map point',
        'mention'           => 'Mention',
        'quest_element'     => 'Quest element',
        'timeline_element'  => 'Timeline element',
    ],
    'create'        => [
        'new_title' => 'New relation',
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
        'owner'             => 'Source',
        'relation'          => 'Relation',
        'target'            => 'Target',
        'target_relation'   => 'Target Relation',
        'two_way'           => 'Create mirror relation',
    ],
    'helper'        => 'Set up relations between entities with attitudes and visibility. Relations can also be pinned to the entity\'s menu.',
    'helpers'       => [
        'no_relations'  => 'This entity doesn\'t currently have any relations to other entities of the campaign.',
        'popup'         => 'Entities of the campaign can be linked together using relations. These can have a description, an attitude rating, a visibility to control who sees a relation, and more.',
    ],
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
        'add'   => 'New relation',
        'title' => 'Relations',
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
        'title' => ':name Connections',
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
