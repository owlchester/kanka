<?php

return [
    'actions'       => [
        'import'    => 'Upload the export',
    ],
    'description'   => 'Import the entities, posts, attributes, the gallery and other elements from a campaign export into this campaigns. This happens in the backend and can take a while, so grab a coffee. You and the other campaign admins will be notified when the import process is done.',
    'fields'        => [
        'file'      => 'Export ZIP file',
        'updated'   => 'Last updated',
    ],
    'limitation'    => 'Only zip files are accepted. Max :size.',
    'status'        => [
        'failed'    => 'Failed',
        'finished'  => 'Finished',
        'queued'    => 'Queued',
        'running'   => 'Running',
    ],
    'title'         => 'Import',
];
