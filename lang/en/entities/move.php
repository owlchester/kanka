<?php

return [
    'actions'       => [
        'copy'      => 'Copy',
        'transfer'  => 'Transfer',
    ],
    'errors'        => [
        'permission'        => 'You aren\'t allowed to create :type entities in :target.',
        'permission_update' => 'You aren\'t allowed to transfer this entity.',
        'same_campaign'     => 'Select another campaign to transfer the entity to.',
        'unknown_campaign'  => 'Unknown campaign.',
    ],
    'fields'        => [
        'campaign'      => 'Target campaign',
        'copy'          => 'Copy option',
        'select_one'    => 'Select a campaign',
    ],
    'helpers'       => [
        'copy'  => 'Keep a copy in the current campaign.',
    ],
    'panel'         => [
        'description'           => 'Transfer this entity to another campaign. You can optionally keep a copy here.',
        'description_bulk_copy' => 'Select a campaign you want to copy the selected entities to.',
        'title'                 => 'Transfer an entity to another campaign',
    ],
    'success'       => 'Entity :name transferred to the :campaign campaign.',
    'success_copy'  => 'Entity :name copied to the :campaign campaign.',
    'title'         => 'Transfer :name',
    'warnings'      => [
        'custom'    => 'This entity is not from a default module, but of a custom ":module" entity type. It will be created as a Note entity in the target campaign.',
    ],
];
