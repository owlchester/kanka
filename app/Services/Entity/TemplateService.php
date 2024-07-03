<?php

namespace App\Services\Entity;

use App\Traits\EntityAware;
use App\Traits\PostAware;

class TemplateService
{
    use EntityAware;
    use PostAware;

    public function toggle(): void
    {
        if (isset($this->post)) {
            $this->post->is_template = !$this->post->is_template;
            $this->post->save();
        } else {
            $this->entity->is_template = !$this->entity->is_template;
            $this->entity->save();
        }
    }
}
