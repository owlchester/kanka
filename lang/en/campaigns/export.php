<?php

return [
    'actions'   => [
        'download'  => 'Download',
        'export'    => 'Export the campaign',
    ],
    'confirm'   => [
        'type'          => 'Export type',
        'notification'  => 'Members of the :admin role will be notified when the export is ready for download.',
        'title'         => 'Export :name',
        'warning'       => 'You are about to export all data from :name. This may take a few minutes depending on campaign size. You\'ll receive a notification when it\'s ready and can continue using Kanka in the meantime.',
    ],
    'errors'    => [
        'limit' => 'The campaign has already been exported once today. Please try again tomorrow.',
        'premium' => 'Markdown export is a feature exclusive to premium campaigns.'
    ],
    'expired'   => 'Link expired',
    'helpers'   => [
        'json'  => 'For backup & restoring - can be used as a campaign import ',
        'markdown' => 'For sharing & reading - human readable format',
        'premium' => 'Available for premium campaigns only.',
    ],
    'progress'  => 'Progress',
    'size'      => 'Size',
    'status'    => [
        'failed'    => 'Failed',
        'finished'  => 'Finished',
        'running'   => 'Running',
        'scheduled' => 'Scheduled',
    ],
    'success'   => 'The campaign export has been queued for processing. All members of the :admin role will be notified once the file is ready for downloading.',
    'title'     => 'Export',
    'type'      => 'Type',
    'types'     => [
        'md'       => 'Markdown',
        'json'     => 'JSON',
    ],
];
