<?php

return [
    'actions'       => [
        'copy'  => 'Copy',
        'move'  => 'Move',
    ],
    'errors'        => [
        'permission'        => 'You aren\'t allowed to create :type entities in :target.',
        'permission_update' => 'You aren\'t allowed to move this entity.',
        'same_campaign'     => 'Select another campaign to move the entity to.',
        'unknown_campaign'  => 'Unknown campaign.',
    ],
    'fields'        => [
        'campaign'      => 'Target campaign',
        'copy'          => 'Create a copy',
        'select_one'    => 'Select a campaign',
    ],
    'helpers'       => [
        'copy'  => 'Keep a copy of the entity in the current campaign.',
    ],
    'panel'         => [
        'description'           => 'Move this entity to another campaign, optionally keeping a copy in the current campaign.',
        'description_bulk_copy' => 'Select a campaign you want to copy the selected entities to.',
        'title'                 => 'Move an entity to another campaign',
    ],
    'success'       => 'Entity :name moved to the :campaign campaign.',
    'success_copy'  => 'Entity :name copied to the :campaign campaign.',
    'title'         => 'Move :name',
    'warnings'      => [
        'custom'    => 'This entity is not from a default module, but of a custom ":module" entity type. It will be created as a Note entity in the target campaign.',
    ],
];
