<?php

namespace App\Services\Entity;

use App\Traits\EntityAware;

class TemplateService
{
    use EntityAware;

    public function toggle(): void
    {
        $this->entity->is_template = !$this->entity->is_template;
        $this->entity->save();
    }
}
