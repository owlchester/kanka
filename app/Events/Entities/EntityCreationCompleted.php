<?php

namespace App\Events\Entities;

use App\Models\Entity;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntityCreationCompleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Entity $entity) {}
}
