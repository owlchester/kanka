<?php

return [
    'actions'           => [
        'import'    => 'Upload the export',
    ],
    'csv'               => [
        'continue'          => 'Continue',
        'fields_helper'     => 'Select a column to assign to each of the fillable fields of the entry.',
        'no_preview'        => 'No preview data available',
        'preview'           => 'Preview',
        'select_module'     => 'Category selection',
        'select_one'        => 'Select one',
        'selected_tags'     => 'Selected tags',
        'set_column'        => 'Set column',
        'set_fields'        => 'Set fields',
        'submit'            => 'Submit CSV import',
        'traits'            => 'Character Traits',
        'traits_helper'     => 'You can add traits to characters, the header you select will be used as the trait, while its corresponding row value will be the traits value as well.',
        'type_helper'       => 'Select the category you want to import the new entries into.',
        'validation_error'  => 'At least 1 column must be fully populated',
    ],
    'description_v2'    => 'Import entries, articles, properties, galleries, and other data from a campaign export  or new entries from a .CSV file into this campaign. The import runs in the background and may take some time. You and any other  admins will be notified when it finishes.',
    'fields'            => [
        'file_v2'   => 'CSV file or export ZIP file',
        'updated'   => 'Last updated',
    ],
    'form'              => 'Upload form',
    'limitation_v2'     => 'Only zip and csv files are accepted. Max :size.',
    'progress'          => [
        'uploading' => 'Uploading',
    ],
    'status'            => [
        'failed'        => 'Failed',
        'finished'      => 'Finished',
        'invalid'       => 'Invalid Data',
        'processing'    => 'Processing',
        'queued'        => 'Queued',
        'ready'         => 'Ready for mapping',
        'running'       => 'Running',
        'validating'    => 'Validating',
    ],
    'title'             => 'Import',
];
