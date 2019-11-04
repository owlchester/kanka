<?php


namespace App\Datagrids\Bulks;


class AttributeTemplateBulk extends Bulk
{
    protected $fields = [
        'name',
        'attribute_template_id',
        'tags',
        'private_choice',
    ];
}
