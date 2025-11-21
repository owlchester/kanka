<?php

return [
    'actions'   => [
        'download'  => 'Download',
        'export'    => 'Export the campaign',
    ],
    'confirm'   => [
        'type'          => 'Export type',
        'notification'  => 'Members of the :admin role will be notified when the export is ready for download.',
        'title'         => 'Export confirmation',
        'warning'       => 'You are about to export all the data from the campaign :name. This process can take a long time depending on the size of campaign and how busy our servers are. You can continue using Kanka while our servers generate the export.',
    ],
    'errors'    => [
        'limit' => 'The campaign has already been exported once today. Please try again tomorrow.',
        'premium' => 'Markdown export is a feature exclusive to premium campaigns.'
    ],
    'expired'   => 'Link expired',
    'helpers'   => [
        'type'  => 'Export as JSON, used for re-importing, or export as markdown, which cannot be used for re-importing',
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
        'md-pitch' => 'Markdown (Premium Campaigns only)',
        'json'     => 'JSON',
    ]
];
