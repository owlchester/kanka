<?php

return [
    'actions'       => [
        'copy'      => 'Copy',
        'transfer'  => 'Transfer',
    ],
    'errors'        => [
        'permission'        => 'You aren\'t allowed to create :type entries in :target.',
        'permission_update' => 'You aren\'t allowed to transfer this entry.',
        'same_campaign'     => 'Select another campaign to transfer the entry to.',
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
        'description'           => 'Transfer this entry to another campaign. You can optionally keep a copy here.',
        'description_bulk_copy' => 'Select a campaign you want to copy the selected entries to.',
        'title'                 => 'Transfer an entry to another campaign',
    ],
    'success'       => 'Entry :name transferred to :campaign.',
    'success_copy'  => 'Entry :name copied to the :campaign campaign.',
    'title'         => 'Transfer :name',
    'warnings'      => [
        'custom'    => 'This entry is not from a default category, but of a custom ":module" category. It will be created as a Note entry in the target campaign.',
    ],
];
