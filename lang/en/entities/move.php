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
        'copy'          => 'Create a copy',
        'select_one'    => 'Select a campaign',
    ],
    'helpers' => [
        'copy' => 'Create a copy of the entity in the target campaign.',
    ],
    'panel'         => [
        'description'           => 'Move this entity to another campaign, or create a copy of it in a target campaign.',
        'description_bulk_copy' => 'Select a campaign you want to copy the selected entities to.',
        'title'                 => 'Move or copy an entity to another campaign',
    ],
    'success'       => 'Entity :name moved to the :campaign campaign.',
    'success_copy'  => 'Entity :name copied to the :campaign campaign.',
    'title'         => 'Move :name',
];
