<?php

namespace App\Services\Permissions;

use App\Enums\Permission;
use App\Facades\Identity;
use App\Facades\Module;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\Scopes\AclScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EntityVisibilityExplanation
{
    public function __construct(protected PermissionService $permissions) {}

    /**
     * @return array{member: string, reason: string, blockingRoles: list<string>, module: string, direct: string, roles: list<array{name: string, membership: string, module: string, entity: string}>}|null
     */
    public function forMissingBinding(Request $request, ModelNotFoundException $exception): ?array
    {
        $route = $request->route();
        if ($exception->getModel() !== Entity::class
            || $route === null
            || ! str_starts_with($route->uri(), 'w/{campaign}/')
            || ! $request->hasSession()
            || ! Identity::isImpersonating()) {
            return null;
        }

        $campaign = $route->parameter('campaign');
        $member = $request->user();
        $originalId = Identity::getImpersonatorId();
        $rawKey = $route->originalParameter('entity');
        if (! $campaign instanceof Campaign
            || $campaign->id !== Identity::getCampaignId()
            || ! $member instanceof User
            || ! is_int($originalId)
            || $member->id === $originalId
            || ! is_string($rawKey)
            || $route->parameter('entity') !== $rawKey
            || ! ctype_digit($rawKey)
            || array_map(strval(...), $exception->getIds()) !== [$rawKey]) {
            return null;
        }

        $id = filter_var(ltrim($rawKey, '0'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false || ! $this->canDiagnose($campaign, $member, $originalId)) {
            return null;
        }

        $entity = $campaign->entities()->getQuery()->withoutGlobalScope(AclScope::class)
            ->whereKey($id)->first(['id', 'campaign_id', 'type_id', 'is_private']);

        return $entity ? $this->explain($campaign, $member, $entity) : null;
    }

    protected function canDiagnose(Campaign $campaign, User $member, int $originalId): bool
    {
        return $campaign->users()->whereKey($member->id)->exists()
            && $campaign->users()->whereKey($originalId)
                ->whereHas('campaignRoles', fn (Builder $query) => $query
                    ->where('campaign_roles.campaign_id', $campaign->id)
                    ->where('campaign_roles.is_admin', true))
                ->exists();
    }

    /**
     * @return array{member: string, reason: string, blockingRoles: list<string>, module: string, direct: string, roles: list<array{name: string, membership: string, module: string, entity: string}>}|null
     */
    protected function explain(Campaign $campaign, User $member, Entity $entity): ?array
    {
        // Use the same scoped lookup as implicit binding, not the controller's EntityPolicy.
        if ($campaign->entities()->whereKey($entity->id)->exists()) {
            return null;
        }

        $engine = $this->permissions->campaign($campaign)->user($member)->action(Permission::View);
        $denied = in_array($entity->id, $engine->deniedEntities());
        $fallback = $engine->fallbackPublicRoleId();
        $assigned = $member->campaignRoles()->where('campaign_roles.campaign_id', $campaign->id)->pluck('campaign_roles.id')->flip();
        $roles = $campaign->roles()->orderBy('name')->orderBy('id')->get(['id', 'name', 'is_admin']);
        $settings = $this->roleSettings($roles->modelKeys(), $entity);
        $direct = CampaignPermission::where('campaign_id', $campaign->id)
            ->where('user_id', $member->id)
            ->where('entity_id', $entity->id)
            ->where('action', Permission::View->value)
            ->pluck('access')->unique();
        if ($direct->count() > 1) {
            return null;
        }
        $direct = $direct->isEmpty() ? 'inherit' : ($direct->first() ? 'allow' : 'deny');

        $blockingRoles = $rows = [];
        $hasConfiguredGrant = $direct === 'allow';
        foreach ($roles as $role) {
            $membership = match (true) {
                $assigned->has($role->id) => 'assigned',
                $role->id === $fallback => 'fallback',
                default => 'unassigned',
            };
            $module = $settings[$role->id]['module'] ?? 'not-granted';
            $individual = $settings[$role->id]['entity'] ?? 'inherit';
            if ($membership === 'unassigned' && ! $role->is_admin && $module !== 'granted' && $individual === 'inherit') {
                continue;
            }
            if ($membership !== 'unassigned') {
                if ($role->is_admin) {
                    return null;
                }
                if ($individual === 'deny') {
                    $blockingRoles[] = $role->name;
                }
                $hasConfiguredGrant = $hasConfiguredGrant || $module === 'granted' || $individual === 'allow';
            }
            $rows[] = [
                'name' => $role->name,
                'membership' => $membership,
                'module' => $role->is_admin ? 'automatic' : $module,
                'entity' => $role->is_admin ? 'automatic' : $individual,
            ];
        }

        $reason = match (true) {
            $entity->is_private => 'private',
            $denied && $direct === 'deny' => 'direct-deny',
            $denied && $blockingRoles !== [] => 'role-deny',
            ! $denied && ! $hasConfiguredGrant && ! in_array($entity->id, $engine->allowedEntities()) && ! in_array($entity->type_id, $engine->allowedEntityTypes()) => 'no-grant',
            default => null,
        };

        $type = $entity->entityType;
        if ($reason === null || ! $type) {
            return null;
        }
        $module = $type->plural ?: Module::campaign($campaign)->plural($type->id, $type->defaultPluralKey());

        return [
            'member' => $member->name,
            'reason' => $reason,
            'blockingRoles' => $blockingRoles,
            'module' => $module ?? $type->pluralCode(),
            'direct' => $direct,
            'roles' => $rows,
        ];
    }

    /**
     * @param  array<int>  $roleIds
     * @return array<int, array<string, string>>
     */
    protected function roleSettings(array $roleIds, Entity $entity): array
    {
        $permissions = CampaignPermission::whereIn('campaign_role_id', $roleIds)
            ->whereNull('user_id')
            ->where('action', Permission::View->value)
            ->where(fn (Builder $query) => $query->where('entity_id', $entity->id)
                ->orWhere(fn (Builder $query) => $query->whereNull('entity_id')->where('entity_type_id', $entity->type_id)))
            ->get(['campaign_role_id', 'entity_id', 'access']);

        $settings = [];
        foreach ($permissions as $permission) {
            if ($permission->entity_id === null) {
                // The binding ACL treats the presence of a module View row as a grant.
                $settings[$permission->campaign_role_id]['module'] = 'granted';
            } elseif (! $permission->access) {
                $settings[$permission->campaign_role_id]['entity'] = 'deny';
            } else {
                $settings[$permission->campaign_role_id]['entity'] ??= 'allow';
            }
        }

        return $settings;
    }
}
