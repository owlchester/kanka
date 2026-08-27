<?php

namespace App\Services\PlayerHub;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityClaim;
use App\Models\PlayerSession;
use App\Models\User;

final readonly class PlayerHubContext
{
    public function __construct(
        public User $user,
        public EntityClaim $claim,
        public Entity $claimedEntity,
        public Campaign $campaign,
        public ?PlayerSession $session = null,
    ) {}
}
