<?php

namespace App\Policies;

class AttributeTemplatePolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.attribute_template');
    }
}
