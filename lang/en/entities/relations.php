<?php

return [
    'actions'           => [
        'mode-map'      => 'Relations map',
        'mode-table'    => 'Table of relations and related elements',
    ],
    'bulk'              => [
        'delete'    => '{0} Deleted :count relations|{1} Deleted :count relation.|[2,*] Deleted :count relations.',
        'fields'    => [
            'delete_mirrored'   => 'Delete mirrored',
            'unmirror'          => 'Unlink mirrored',
            'update_mirrored'   => 'Update mirrored',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Also delete mirrored relations.',
            'unmirror'          => 'Unlink mirrored relations.',
            'update_mirrored'   => 'Update mirrored relations.',
        ],
        'success'   => [
            'editing'           => '{0} :count relations were updated|{1} :count relation was updated.|[2,*] :count relationss were updated.',
            'editing_partial'   => '{0} :count/:total relationss were updated|{1} :count/:total relation was updated.|[2,*] :count/:total relations were updated.',
        ],
    ],
    'call-to-action'    => 'Visually explore how this entry connects to others in the campaign. See relationships, mentions, and shared history in a dynamic and interactive map.',
    'connections'       => [
        'map_point'         => 'Map point',
        'mention'           => 'Mention',
        'quest_element'     => 'Quest element',
        'timeline_element'  => 'Timeline element',
    ],
    'create'            => [
        'helper'        => 'Create a relation between :name and one or several entries.',
        'new_title'     => 'New relation',
        'success_bulk'  => '{1} Added :count relation to :entity.|[2,*] Added :count relations to :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'This relation is mirrored on the target entry. Select this option to also remove the mirrored relation.',
        'option'    => 'Delete mirrored relation',
    ],
    'destroy'           => [
        'mirrored'  => 'This will also delete the mirrored relation and is permanent.',
        'success'   => 'Relation :target removed for :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Attitude',
        'is_pinned'         => 'Pinned',
        'owner'             => 'Origin',
        'role'              => 'Role',
        'target'            => 'Target',
        'targets'            => 'Connection to...',
        'mirror_relation' => 'Reciprocal role',
        'link'              => 'Reciprocal link',
        'two_way'           => 'Reciprocal',
        'unmirror'          => 'Untie this relation.',
    ],
    'filters'           => [
        'connection'    => 'Relation relation',
        'name'          => 'Relation target',
    ],
    'helper'            => 'Set up relations between entries with attitudes and visibility. Relations can also be pinned to the entry\'s menu.',
    'helpers'           => [
        'link' => 'Create a matching relation on the targets.',
        'mirror_relation' => 'How the target sees this entry (leave blank to copy above).',
        'description'   => 'Detail the nature of the relation between the two entries.',
        'no_relations'  => 'This entry doesn\'t currently have any relations to other entries of the campaign.',
    ],
    'hints'             => [
        'attitude'          => 'This optional field can be used to define the default order relations appear in by descending order.',
        'two_way'           => 'Create a mirrored relation on the targets. Updating a mirrored relation doesn\'t update the original relation.',
    ],
    'linked' => [
        'label' => 'Linked relation',
        'helper' => 'This relation is synced with :link',
        'break' => 'Break link',
        'unmirror-helper' => 'Converting this to a standalone relation will not delete anything.',
    ],
    'index'             => [
        'title' => 'Relations',
    ],
    'options'           => [
        'mentions'          => 'Default + related + mentions',
        'only_relations'    => 'Only direct relations',
        'related'           => 'Default + related',
        'relations'         => 'Default',
        'show'              => 'Show',
    ],
    'panels'            => [
        'related'   => 'Related',
    ],
    'placeholders'      => [
        'attitude'          => '-100 to 100, 100 being very positive',
        'role'          => 'Rival, Best Friend, Sibling',
    ],
    'show'              => [
        'title' => ':name relations',
    ],
    'types'             => [
        'family_member'         => 'Family member',
        'organisation_member'   => 'Organisation Member',
    ],
    'update'            => [
        'success'   => 'Relation :target updated for :entity.',
        'title'     => 'Update relations between :source and :target',
    ],
];
