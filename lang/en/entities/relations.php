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
    'call-to-action'    => 'Visually explore how this entity connects to others in the campaign. See relationships, mentions, and shared history in a dynamic and interactive map.',
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
        'owner'             => 'Origin',
        'role'          => 'Role',
        'target'            => 'Target',
        'targets'            => 'Connection to...',
        'mirror_relation' => 'Reciprocal role',
        'targets'           => 'Target entities',
        'link'              => 'Reciprocal link',
        'two_way'           => 'Reciprocal',
        'unmirror'          => 'Untie this connection.',
    ],
    'filters'           => [
        'connection'    => 'Connection relation',
        'name'          => 'Connection target',
    ],
    'helper'            => 'Set up connections between entities with attitudes and visibility. Connections can also be pinned to the entity\'s menu.',
    'helpers'           => [
        'link' => 'Create a matching relation on the targets.',
        'mirror_relation' => 'How the target sees this entity (leave blank to copy above).',
        'description'   => 'Detail the nature of the connection between the two entities.',
        'no_relations'  => 'This entity doesn\'t currently have any connection to other entities of the campaign.',
    ],
    'hints'             => [
        'attitude'          => 'This optional field can be used to define the default order connections appear in by descending order.',
        'two_way'           => 'Create a mirrored connection on the targets. Updating a mirrored connection doesn\'t update the original connection.',
    ],
    'linked' => [
        'label' => 'Linked connection',
        'helper' => 'This relation is synced with :link',
        'break' => 'Break link',
        'unmirror-helper' => 'Converting this to a standalone relation will not delete anything.',
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
