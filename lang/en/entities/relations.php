<?php

return [
    'actions'           => [
        'mode-map'      => 'Connections map',
        'mode-table'    => 'Table of connections and related elements',
    ],
    'bulk'              => [
        'delete'    => '{0} Deleted :count connections|{1} Deleted :count connection.|[2,*] Deleted :count connections.',
        'fields'    => [
            'delete_mirrored'   => 'Delete mirrored',
            'unmirror'          => 'Unlink mirrored',
            'update_mirrored'   => 'Update mirrored',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Also delete mirrored connections.',
            'unmirror'          => 'Unlink mirrored connections.',
            'update_mirrored'   => 'Update mirrored connections.',
        ],
        'success'   => [
            'editing'           => '{0} :count connections were updated|{1} :count connection was updated.|[2,*] :count connections were updated.',
            'editing_partial'   => '{0} :count/:total connections were updated|{1} :count/:total connection was updated.|[2,*] :count/:total connection were updated.',
        ],
    ],
    'call-to-action'    => 'Visually explore the connections of this entity and how it\'s connected to the rest of the campaign.',
    'connections'       => [
        'map_point'         => 'Map point',
        'mention'           => 'Mention',
        'quest_element'     => 'Quest element',
        'timeline_element'  => 'Timeline element',
    ],
    'create'            => [
        'helper'        => 'Create a connection between :name and one or several entities.',
        'new_title'     => 'New connection',
        'success_bulk'  => '{1} Added :count connection to :entity.|[2,*] Added :count connections to :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'This connection is mirrored on the target entity. Select this option to also remove the mirrored connection.',
        'option'    => 'Delete mirrored connection',
    ],
    'destroy'           => [
        'mirrored'  => 'This will also delete the mirrored connection and is permanent.',
        'success'   => 'Connection :target removed for :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Attitude',
        'connection'        => 'Connection',
        'is_pinned'         => 'Pinned',
        'owner'             => 'Source',
        'relation'          => 'Description',
        'target'            => 'Target entity',
        'targets'            => 'Target entities',
        'target_relation'   => 'Target\'s description',
        'two_way'           => 'Mirror connection',
        'unmirror'          => 'Unmirror this connection.',
    ],
    'filters'           => [
        'connection'    => 'Connection relation',
        'name'          => 'Connection target',
    ],
    'helper'            => 'Set up connections between entities with attitudes and visibility. Connections can also be pinned to the entity\'s menu.',
    'helpers'           => [
        'description'   => 'Detail the nature of the connection between the two entities.',
        'no_relations'  => 'This entity doesn\'t currently have any connection to other entities of the campaign.',
        'popup'         => 'Entities of the campaign can be linked together using connections. These can have a description, an attitude rating, a visibility to control who sees a connection, and more.',
    ],
    'hints'             => [
        'attitude'          => 'This optional field can be used to define the default order connections appear in by descending order.',
        'mirrored'          => [
            'text'  => 'This connection is mirrored with :link.',
            'title' => 'Mirrored',
        ],
        'target_relation'   => 'The connection description on the target. Leave blank to use this connection\'s text.',
        'two_way'           => 'Create a mirrored connection on the target entity. Updating a mirrored connection doesn\'t update the original connection.',
    ],
    'index'             => [
        'title' => 'Connections',
    ],
    'options'           => [
        'mentions'          => 'Default + related + mentions',
        'only_relations'    => 'Only direct connection',
        'related'           => 'Default + related',
        'relations'         => 'Default',
        'show'              => 'Show',
    ],
    'panels'            => [
        'related'   => 'Related',
    ],
    'placeholders'      => [
        'attitude'          => '-100 to 100, 100 being very positive',
        'relation'          => 'Rival, Best Friend, Sibling',
        'target'            => 'Choose an entity',
        'target_relation'   => 'Leave blank to use the description',
    ],
    'show'              => [
        'title' => ':name Connections',
    ],
    'types'             => [
        'family_member'         => 'Family member',
        'organisation_member'   => 'Organisation Member',
    ],
    'update'            => [
        'success'   => 'Connection :target updated for :entity.',
        'title'     => 'Update connections for :name',
    ],
];
