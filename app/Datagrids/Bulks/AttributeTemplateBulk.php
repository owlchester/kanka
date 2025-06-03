<?php

namespace App\Datagrids\Bulks;

class AttributeTemplateBulk extends Bulk
{
    protected array $fields = [
        'name',
        // 'attribute_template_id',
        // 'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];

    protected $booleans = [
        'is_enabled',
    ];
}
