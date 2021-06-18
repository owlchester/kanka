<?php

return [
    'actions'       => [
        'copy'  => 'Copy',
        'move'  => 'Move',
    ],
    'errors'        => [
        'permission'        => 'You aren\'t allowed to create entities of that type in the target campaign.',
        'permission_update' => 'You aren\'t allowed to move this entity.',
        'same_campaign'     => 'You need to select another campaign to move the entity to.',
        'unknown_campaign'  => 'Unknown campaign.',
    ],
    'fields'        => [
        'campaign'      => 'Target campaign',
        'copy'          => 'Make a copy',
        'select_one'    => 'Select a campaign',
    ],
    'panel'         => [
        'description'           => 'Select a campaign you want to move or make a copy of this entity in.',
        'description_bulk_copy' => 'Select a campaign you want to copy the selected entities to.',
        'title'                 => 'Move or copy an entity to another campaign',
    ],
    'success'       => 'Entity :name moved.',
    'success_copy'  => 'Entity :name copied.',
    'title'         => 'Move :name',
];
