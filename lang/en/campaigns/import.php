<?php

return [
    'actions'       => [
        'import'    => 'Upload the export',
    ],
    'description'   => 'Import entities, posts, attributes, galleries, and other data from a campaign export into this campaign. The import runs in the background and may take some time. You and any other campaign admins will be notified when it finishes.',
    'fields'        => [
        'file'      => 'Export ZIP file',
        'updated'   => 'Last updated',
    ],
    'form'          => 'Upload form',
    'limitation'    => 'Only zip files are accepted. Max :size.',
    'progress'      => [
        'uploading' => 'Uploading',
        'validating'=> 'Validating',
    ],
    'status'        => [
        'failed'    => 'Failed',
        'finished'  => 'Finished',
        'queued'    => 'Queued',
        'running'   => 'Running',
    ],
    'title'         => 'Import',
];
