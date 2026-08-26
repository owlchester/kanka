<?php

namespace App\Events\Entities;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class EntityCreationCompleted
{
    use Dispatchable;
    use SerializesModels;
    use ShouldDispatchAfterCommit;

    public function __construct(public Entity $entity, public ?User $user = null) {}
}
