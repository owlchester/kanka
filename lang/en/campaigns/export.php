<?php

return [
    'actions'   => [
        'export'    => 'Export the campaign',
        'download'        => 'Download',
    ],
    'errors'    => [
        'limit' => 'The campaign has already been exported once today. Please try again tomorrow.',
    ],
    'confirm' => [
        'title' => 'Export confirmation',
        'warning' => 'You are about to export the campaign\'s data. This process can take a long time depending on the size of campaign. You can continue using Kanka while our servers generate the export.',
    ],
    'success'   => 'The campaign export is being prepared. You will be notified in Kanka once it\'s ready for downloading.',
    'title'     => 'Campaign Export',
    'size'            => 'Size',
    'type'            => 'Type',
    'status' => [
        'finished'  => 'Finished',
        'scheduled' => 'Scheduled',
        'failed'    => 'Failed',
        'running'   => 'Running',
    ],
    'type_assets'     => 'Assets',
    'type_entities'   => 'Entities',
    'expired'         => 'Link expired',
];
