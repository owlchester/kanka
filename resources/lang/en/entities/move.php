<?php

return [
    'actions'       => [
        'move'      => 'Move',
        'copy'      => 'Copy',
    ],
    'errors'        => [
        'permission'        => 'You aren\'t allowed to create entities of that type in the target campaign.',
        'same_campaign'     => 'You need to select another campaign to move the entity to.',
        'unknown_campaign'  => 'Unknown campaign.',
        'permission_update' => 'Trying to move an entity that can\'t be updated.',
    ],
    'fields'        => [
        'campaign'      => 'Target campaign',
        'copy'          => 'Make a copy',
        'select_one'    => 'Select a campaign',
    ],
    'panel'        => [
        'title'                 => 'Move or copy an entity to another campaign',
        'description'           => 'Select a campaign you want to move or make a copy of this entity in.',
        'description_bulk_copy' => 'Select a campaign you want to copy these entities to.',
    ],
    'success'       => 'Entity \':name\' moved.',
    'success_copy'  => 'Entity \':name\' copied.',
    'title'         => 'Move :name',
];
