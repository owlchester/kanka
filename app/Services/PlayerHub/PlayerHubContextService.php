<?php

namespace App\Services\PlayerHub;

use App\Facades\Avatar;
use App\Facades\BookmarkCache;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityAssetCache;
use App\Facades\EntityCache;
use App\Facades\EntityPermission;
use App\Facades\Img;
use App\Facades\MapMarkerCache;
use App\Facades\Module;
use App\Facades\Permissions;
use App\Facades\QuestCache;
use App\Facades\TimelineElementCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityClaim;
use App\Models\PlayerSession;
use App\Models\Scopes\AclScope;
use App\Models\Scopes\CampaignScope;
use App\Models\User;
use App\Services\PlayerHub\PlayerHubContext as Context;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlayerHubContextService
{
    public function __construct(
        protected EntityQueryService $entityQueryService,
    ) {}

    public function forClaim(User $user, int|EntityClaim $claim): Context
    {
        $claimId = $claim instanceof EntityClaim ? $claim->id : $claim;

        $resolvedClaim = $this->entityQueryService
            ->activeClaimsFor($user)
            ->whereKey($claimId)
            ->first();

        if (! $resolvedClaim instanceof EntityClaim) {
            throw (new ModelNotFoundException)->setModel(EntityClaim::class, [$claimId]);
        }

        return $this->makeContext($user, $resolvedClaim);
    }

    public function forSession(User $user, int $session): Context
    {
        $playerSession = $this->entityQueryService
            ->activeSessionsFor($user)
            ->whereKey($session)
            ->first();

        if (! $playerSession instanceof PlayerSession) {
            throw (new ModelNotFoundException)->setModel(PlayerSession::class, [$session]);
        }

        $context = $this->forClaim($user, $playerSession->entity_claim_id);

        return new Context(
            user: $context->user,
            claim: $context->claim,
            claimedEntity: $context->claimedEntity,
            campaign: $context->campaign,
            session: $playerSession,
        );
    }

    public function activate(Context $context): void
    {
        $this->activateCampaign($context->campaign, $context->user);
    }

    public function activateCampaign(Campaign $campaign, User $user): void
    {
        CampaignLocalization::forceCampaign($campaign);

        CampaignCache::campaign($campaign)->user($user);
        EntityCache::campaign($campaign);
        UserCache::campaign($campaign)->user($user);
        CharacterCache::campaign($campaign);
        QuestCache::campaign($campaign);
        MapMarkerCache::campaign($campaign);
        EntityAssetCache::campaign($campaign);
        BookmarkCache::campaign($campaign);
        TimelineElementCache::campaign($campaign);

        Permissions::forContext($campaign, $user);
        EntityPermission::forContext($campaign, $user);
        Module::campaign($campaign);
        Avatar::campaign($campaign)->user($user)->reset();
        Img::reset();
    }

    protected function makeContext(User $user, EntityClaim $claim): Context
    {
        $claimedEntity = Entity::query()
            ->withoutGlobalScopes([AclScope::class, CampaignScope::class])
            ->whereKey($claim->entity_id)
            ->firstOrFail();

        return new Context(
            user: $user,
            claim: $claim,
            claimedEntity: $claimedEntity,
            campaign: $claimedEntity->campaign,
        );
    }
}
