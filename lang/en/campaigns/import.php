<?php

return [
    'actions' => [
        'import' => 'Upload the export',
    ],
    'title' => 'Import',
    'fields' => [
        'file' => 'Export ZIP file',
        'updated' => 'Last updated',
    ],
    'limitation' => 'Only zip files are accepted. Max 512MB.',
    'form' => 'Select a campaign export to import into this campaign.',
    'description' => 'Import the entities, posts, attributes, the gallery and other elements from a campaign export into this campaigns. This happens in the backend and can take a while, so grab a coffee. You and the other campaign admins will be notified when the import process is done.',
    'status' => [
        'running' => 'Running',
        'queued' => 'Queued',
        'finished' => 'Finished',
        'failed' => 'Failed',
    ],
];
