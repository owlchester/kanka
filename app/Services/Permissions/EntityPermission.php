<?php

namespace App\Services\Permissions;

use App\Enums\Permission;
use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Models\User;

class EntityPermission
{
    /**
     * In-memory permission map keyed by "{campaignId}:{userId}" (0 for guest).
     *
     * @var array<string, array{isAdmin: bool, cached: array<string, bool>}>
     */
    protected array $cache = [];

    public function canEntity(Entity $entity, Permission $permission, ?User $user = null, ?Campaign $campaign = null): bool
    {
        $resolvedCampaign = $this->resolveCampaign($campaign, $entity);
        $state = $this->loadState($resolvedCampaign, $user);

        if ($state['isAdmin']) {
            return true;
        }

        $moduleKey = $entity->type_id . '_' . $permission->value;
        $perm = ! empty($state['cached'][$moduleKey]);

        $entityKey = '_' . $permission->value . '_' . $entity->id;
        if (array_key_exists($entityKey, $state['cached'])) {
            return $state['cached'][$entityKey];
        }

        return $perm;
    }

    public function canEntityType(EntityType $entityType, Permission $permission, ?User $user = null, ?Campaign $campaign = null): bool
    {
        $resolvedCampaign = $this->resolveCampaign($campaign);
        $state = $this->loadState($resolvedCampaign, $user);

        if ($state['isAdmin']) {
            return true;
        }

        $moduleKey = $entityType->id . '_' . $permission->value;

        return ! empty($state['cached'][$moduleKey]);
    }

    /**
     * Determine the permission for a user to interact with an entity or campaign action.
     *
     * @param  MiscModel|Entity|null  $entity
     */
    public function hasPermission(
        int $entityType,
        int $action,
        $entity = null,
        ?User $user = null,
        ?Campaign $campaign = null,
    ): bool {
        $resolvedCampaign = $this->resolveCampaign($campaign, $entity);
        $state = $this->loadState($resolvedCampaign, $user);

        if ($state['isAdmin']) {
            return true;
        }

        $typeKey = $entityType === 0 ? 'campaign' : (string) $entityType;
        $key = $typeKey . '_' . $action;
        $perm = ! empty($state['cached'][$key]);

        if (! empty($entity)) {
            $entityKey = isset($entity->type_id)
                ? '_' . $action . '_' . $entity->entity_id
                : '_' . $action . '_' . $entity->id;

            if (array_key_exists($entityKey, $state['cached'])) {
                $perm = $state['cached'][$entityKey];
            }
        }

        return $perm;
    }

    /**
     * Determine if a user is part of a role that can do an action on all entities of a campaign.
     */
    public function canRole(string $action, string $modelName, ?User $user = null, ?Campaign $campaign = null): bool
    {
        $resolvedCampaign = $this->resolveCampaign($campaign);
        $state = $this->loadState($resolvedCampaign, $user);

        return ! empty($state['cached'][$modelName . '_' . $action]);
    }

    /**
     * Reset all cached permissions.
     */
    public function resetPermissions(): void
    {
        $this->cache = [];
    }

    /**
     * @param  MiscModel|Entity|null  $entity
     */
    protected function resolveCampaign(?Campaign $campaign, $entity = null): ?Campaign
    {
        if ($campaign) {
            return $campaign;
        }

        if ($entity instanceof Entity && $entity->campaign) {
            return $entity->campaign;
        }

        if ($entity instanceof MiscModel && $entity->entity?->campaign) {
            return $entity->entity->campaign;
        }

        if (CampaignLocalization::hasCampaign()) {
            return CampaignLocalization::getCampaign();
        }

        return null;
    }

    /**
     * @return array{isAdmin: bool, cached: array<string, bool>}
     */
    protected function loadState(?Campaign $campaign, ?User $user): array
    {
        if (! $campaign) {
            if (app()->environment('testing')) {
                return ['isAdmin' => true, 'cached' => []];
            }

            abort(404);
        }

        $cacheKey = $campaign->id . ':' . ($user->id ?? 0);

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $roles = $user
            ? UserCache::user($user)->campaign($campaign)->roles()
            : collect();

        if ($roles->isEmpty()) {
            $roles = $campaign->roles()->where('is_public', true)->get();
        }

        $campaignRoleIDs = [];
        /** @var CampaignRole|array<string, mixed> $role */
        foreach ($roles as $role) {
            if ($role['is_admin']) {
                return $this->cache[$cacheKey] = ['isAdmin' => true, 'cached' => []];
            }
            $campaignRoleIDs[] = $role['id'];
        }

        $cached = [];

        if (! empty($campaignRoleIDs)) {
            $permissions = app(RolePermission::class)->rolesPermissions($campaignRoleIDs);

            /** @var CampaignPermission $permission */
            foreach ($permissions as $permission) {
                $cached[$permission->key()] = (bool) $permission->access;
            }
        }

        if ($user) {
            $userPermissions = $user->permissions()->where('campaign_id', $campaign->id)->get();

            /** @var CampaignPermission $permission */
            foreach ($userPermissions as $permission) {
                $cached[$permission->key()] = (bool) $permission->access;
            }
        }

        return $this->cache[$cacheKey] = [
            'isAdmin' => false,
            'cached' => $cached,
        ];
    }
}
