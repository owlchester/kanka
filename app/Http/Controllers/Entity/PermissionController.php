<?php

namespace App\Http\Controllers\Entity;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermission;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function view(Request $request, Campaign $campaign, Entity $entity)
    {
        $user = $request->user();
        $canTogglePrivacy = $user->can('privacy', [$entity, $campaign]);
        $canEditPermissions = $user->can('permissions', $entity);

        if (! $canTogglePrivacy && ! $canEditPermissions) {
            abort(403);
        }

        $isAdmin = $user->can('admin', $campaign);
        $this->permissionService->campaign($campaign)->entityType($entity->entityType);
        $entityPermissions = $this->permissionService->entityPermissions($entity);

        $actions = [
            Permission::View,
            Permission::Update,
            Permission::Delete,
            Permission::Posts,
        ];

        $rolesData = [];
        foreach ($campaign->roles()->withoutAdmin()->get() as $role) {
            $this->permissionService->reset()->role($role);
            $perms = [];
            $inherited = [];
            foreach ($actions as $action) {
                $this->permissionService->action($action);
                $perms[$action->value] = $this->permissionService->selected('role');
                $inherited[$action->value] = $this->permissionService->inherited();
            }

            $rolesData[] = [
                'id' => $role->id,
                'name' => $role->name,
                'is_public' => $role->isPublic(),
                'role_url' => $user->can('update', $role) ? route('campaign_roles.show', [$campaign, $role]) : null,
                'public_warning' => $role->isPublic() && ! $campaign->isPublic(),
                'perms' => $perms,
                'inherited' => $inherited,
            ];
        }

        $membersCatalog = [];
        foreach ($campaign->nonAdminMembers()->with('user')->get() as $member) {
            if (! $member->user) {
                continue;
            }

            $this->permissionService->reset()->user($member->user);
            $perms = [];
            $inherited = [];
            $inheritedAccess = [];
            foreach ($actions as $action) {
                $this->permissionService->action($action);
                $perms[$action->value] = $this->permissionService->selected('user');
                $isInherited = $this->permissionService->inherited();
                $inherited[$action->value] = $isInherited;
                $inheritedAccess[$action->value] = $isInherited ? $this->permissionService->inheritedRoleAccess() : false;
            }

            $membersCatalog[] = [
                'id' => $member->user_id,
                'name' => $member->user->name,
                'initials' => $member->user->initials(),
                'avatar' => $member->user->hasAvatar() ? $member->user->getAvatarUrl(40) : null,
                'switch_url' => ($isAdmin && $user->can('switch', $member))
                    ? route('identity.switch-entity', [$campaign, $member, $entity])
                    : null,
                'perms' => $perms,
                'inherited' => $inherited,
                'inherited_access' => $inheritedAccess,
                'has_override' => isset($entityPermissions['user'][$member->user_id]),
            ];
        }

        return view('entities.pages.permissions.index', compact(
            'entity',
            'campaign',
            'canTogglePrivacy',
            'canEditPermissions',
            'rolesData',
            'membersCatalog',
        ));
    }

    public function store(StorePermission $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('permissions', $entity);

        $this->permissionService
            ->campaign($campaign)
            ->user($request->user())
            ->entity($entity)
            ->save($request->only('role', 'user'));

        return redirect()->back()
            ->with('success_raw', __('crud.permissions.success'));
    }
}
