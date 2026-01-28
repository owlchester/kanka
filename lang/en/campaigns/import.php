<?php

return [
    'actions'       => [
        'import'    => 'Upload the export',
    ],
    'csv'           => [
        'continue'      => 'Continue',
        'set_fields'    => 'Set fields',
        'fields_helper' => 'Select a column to assign to each of the fillable fields of the entity.',
        'type_helper'   => 'Select the entity type you want to import the new modules into',
        'no_preview'    => 'No preview data available',
        'select_type'   => 'Select entity type',
        'set_column'    => 'Set column', 
        'success'       => 'Successfully imported :count entities via CSV import.',
        'submit'        => 'Submit',
        'preview'       => 'Preview',
        'traits'        => 'Character Traits',
        'traits_helper' => 'You can add traits to characters, the header you select will be used as the trait, while its corresponding row value will be the traits value as well.',
        'add_personality'   => 'Add a personality trait',
        'add_appearance'    => 'Add a appearance trait',
        'appearance'        => 'Appearance traits',
        'personality'       => 'Personality traits',
        'select_one'        => 'Select one',
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
        'failed'        => 'Failed',
        'finished'      => 'Finished',
        'queued'        => 'Queued',
        'running'       => 'Running',
        'ready'         => 'Ready',
        'validating'    => 'Mapping',
        'invalid'       => 'Invalid Data',
    ],
    'title'         => 'Import',
];
