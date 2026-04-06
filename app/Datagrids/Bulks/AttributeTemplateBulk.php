<?php

namespace App\Datagrids\Bulks;

class AttributeTemplateBulk extends Bulk
{
    protected array $fields = [
        'name',
        // 'attribute_template_id',
        // 'tags',
        'parent_id',
        'entity_type_id',
        'private_choice',
        'enabled_choice',
        'entity_image',
        'entity_header',
    ];

    protected array $booleans = [
        'is_enabled',
    ];
}
