<?php

namespace App\Services\PlayerHub;

use App\Enums\CampaignFlags;
use App\Enums\Permission;
use App\Models\Entity;
use App\Models\EntityClaim;
use App\Models\PlayerSession;
use App\Models\Scopes\AclScope;
use App\Models\Scopes\CampaignScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EntityQueryService
{
    /**
     * Get entities visible to a user in their enabled Player Hub campaigns.
     */
    /**
     * @return Builder<Entity>
     */
    public function visibleTo(User $user): Builder
    {
        $campaignIds = $this->campaignIds($user);

        return Entity::query()
            ->withoutGlobalScopes([CampaignScope::class, AclScope::class])
            ->whereIn('entities.campaign_id', $campaignIds)
            ->with([
                'campaign',
                'entityType',
                'claims' => function ($query): void {
                    $query->whereNull('unclaimed_at');
                },
                'image',
            ])
            ->where(function ($query) use ($user): void {
                $query->whereExists(function ($admin) use ($user): void {
                    $admin
                        ->selectRaw('1')
                        ->from('campaign_role_users as admin_role_users')
                        ->join('campaign_roles as admin_roles', 'admin_roles.id', '=', 'admin_role_users.campaign_role_id')
                        ->where('admin_role_users.user_id', $user->id)
                        ->where('admin_roles.is_admin', true)
                        ->whereColumn('admin_roles.campaign_id', 'entities.campaign_id');
                })->orWhere(function ($query) use ($user): void {
                    $query
                        ->where('entities.is_private', false)
                        ->where(function ($query) use ($user): void {
                            $query
                                ->whereExists(function ($permission) use ($user): void {
                                    $this->rolePermissionQuery($permission, $user)
                                        ->where('campaign_permissions.access', true)
                                        ->whereNull('campaign_permissions.entity_id')
                                        ->whereColumn('campaign_permissions.entity_type_id', 'entities.type_id');
                                })
                                ->orWhereExists(function ($permission) use ($user): void {
                                    $this->rolePermissionQuery($permission, $user)
                                        ->where('campaign_permissions.access', true)
                                        ->whereColumn('campaign_permissions.entity_id', 'entities.id');
                                })
                                ->orWhereExists(function ($permission) use ($user): void {
                                    $permission
                                        ->selectRaw('1')
                                        ->from('campaign_permissions')
                                        ->where('campaign_permissions.user_id', $user->id)
                                        ->whereColumn('campaign_permissions.campaign_id', 'entities.campaign_id')
                                        ->where('campaign_permissions.action', Permission::View->value)
                                        ->where('campaign_permissions.access', true)
                                        ->whereColumn('campaign_permissions.entity_id', 'entities.id');
                                });
                        })
                        ->whereNotExists(function ($permission) use ($user): void {
                            $permission
                                ->selectRaw('1')
                                ->from('campaign_permissions')
                                ->where('campaign_permissions.user_id', $user->id)
                                ->whereColumn('campaign_permissions.campaign_id', 'entities.campaign_id')
                                ->where('campaign_permissions.action', Permission::View->value)
                                ->where('campaign_permissions.access', false)
                                ->whereColumn('campaign_permissions.entity_id', 'entities.id');
                        })
                        ->where(function ($query) use ($user): void {
                            $query
                                ->whereNotExists(function ($permission) use ($user): void {
                                    $this->rolePermissionQuery($permission, $user)
                                        ->where('campaign_permissions.access', false)
                                        ->whereColumn('campaign_permissions.entity_id', 'entities.id');
                                })
                                ->orWhereExists(function ($permission) use ($user): void {
                                    $permission
                                        ->selectRaw('1')
                                        ->from('campaign_permissions')
                                        ->where('campaign_permissions.user_id', $user->id)
                                        ->whereColumn('campaign_permissions.campaign_id', 'entities.campaign_id')
                                        ->where('campaign_permissions.action', Permission::View->value)
                                        ->where('campaign_permissions.access', true)
                                        ->whereColumn('campaign_permissions.entity_id', 'entities.id');
                                });
                        });
                });
            })
            ->orderBy('entities.id');
    }

    /**
     * @return Builder<EntityClaim>
     */
    public function activeClaimsFor(User $user): Builder
    {
        $visibleEntities = $this->visibleTo($user)
            ->select('entities.id')
            ->reorder();

        return EntityClaim::query()
            ->where('entity_claims.user_id', $user->id)
            ->whereNull('entity_claims.unclaimed_at')
            ->whereIn('entity_claims.entity_id', $visibleEntities);
    }

    /**
     * @return Builder<PlayerSession>
     */
    public function activeSessionsFor(User $user): Builder
    {
        return PlayerSession::query()
            ->where('player_sessions.created_by', $user->id)
            ->whereIn('player_sessions.entity_claim_id', $this->activeClaimsFor($user)->select('entity_claims.id'));
    }

    /**
     * Return membership campaigns with Player Hub enabled.
     *
     * @return array<int, int>
     */
    protected function campaignIds(User $user): array
    {
        return DB::table('campaign_user')
            ->join('campaigns', 'campaigns.id', '=', 'campaign_user.campaign_id')
            ->join('campaign_flags', 'campaign_flags.campaign_id', '=', 'campaign_user.campaign_id')
            ->where('campaign_user.user_id', $user->id)
            ->whereNull('campaigns.deleted_at')
            ->where('campaign_flags.flag', CampaignFlags::PlayerHub->value)
            ->distinct()
            ->pluck('campaign_user.campaign_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }

    /**
     * Start a permission query for the user's roles in the entity's campaign.
     */
    protected function rolePermissionQuery($query, User $user)
    {
        return $query
            ->selectRaw('1')
            ->from('campaign_permissions')
            ->join('campaign_role_users', 'campaign_role_users.campaign_role_id', '=', 'campaign_permissions.campaign_role_id')
            ->join('campaign_roles', 'campaign_roles.id', '=', 'campaign_role_users.campaign_role_id')
            ->where('campaign_role_users.user_id', $user->id)
            ->where('campaign_permissions.action', Permission::View->value)
            ->whereColumn('campaign_roles.campaign_id', 'entities.campaign_id');
    }
}
