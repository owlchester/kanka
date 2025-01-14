<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Facades\EntitySetup;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRole;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Services\Permissions\RolePermissionService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected string $view = 'campaigns.roles';

    protected RolePermissionService $service;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(RolePermissionService $rolePermissionService)
    {
        $this->middleware('auth');
        $this->service = $rolePermissionService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);
        Datagrid::layout(\App\Renderers\Layouts\Campaign\CampaignRole::class);

        $roles = $campaign->roles()
            ->sort(request()->only(['o', 'k']))
            ->with(['users', 'permissions', 'campaign'])
            ->orderBy('is_admin', 'DESC')
            ->orderBy('is_public', 'DESC')
            ->orderBy('name')
            ->paginate();

        $rows = $roles;

        // Ajax Datagrid
        if (request()->ajax()) {
            $html = view('layouts.datagrid._table')->with('rows', $rows)->with('campaign', $campaign)->render();
            $deletes = view('layouts.datagrid.delete-forms')->with('models', Datagrid::deleteForms())->with('campaign', $campaign)->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'deletes' => $deletes,
            ]);
        }

        return view('campaigns.roles', compact('campaign', 'rows', 'roles'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('create', CampaignRole::class);
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('campaign', $campaign)
                ->with('name', 'campaign_roles');
        }

        return view($this->view . '.create', ['campaign' => $campaign, 'model' => $campaign]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function duplicate(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('create', CampaignRole::class);
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('campaign', $campaign)
                ->with('name', 'campaign_roles');
        }

        return view($this->view . '.create', ['campaign' => $campaign, 'model' => $campaign, 'roleId' => $campaignRole->id]);
    }

    public function store(StoreCampaignRole $request, Campaign $campaign)
    {
        $this->authorize('create', CampaignRole::class);
        if ($request->ajax()) {
            return response()->json();
        }
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('campaign', $campaign)
                ->with('name', 'campaign_roles');
        }
        $data = $request->all() + ['campaign_id' => $campaign->id];
        $role = CampaignRole::create($data);
        if ($request->has('duplicate') && $request->get('duplicate') != 0) {
            /** @var CampaignRole $copy */
            $copy = CampaignRole::where('id', $request->get('role_id'))->first();
            if ($copy) {
                $copy->duplicate($role);
            }
        }
        return redirect()->route('campaign_roles.index', $campaign)
            ->with('success_raw', __($this->view . '.create.success', ['name' => $role->name]));
    }

    public function show(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('view', [$campaignRole, $campaign]);

        $members = $campaignRole
            ->users()
            ->with('user')
            ->paginate();

        return view($this->view . '.show', [
            'model' => $campaign,
            'role' => $campaignRole,
            'campaign' => $campaign,
            'members' => $members,
            'permissionService' => $this->service->campaign($campaign)->role($campaignRole)
        ]);
    }

    public function edit(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('view', [$campaignRole, $campaign]);
        $this->authorize('update', $campaignRole);

        return view($this->view . '.edit', [
            'campaign' => $campaign,
            'model' => $campaign,
            'role' => $campaignRole,
        ]);
    }

    public function update(StoreCampaignRole $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('view', [$campaignRole, $campaign]);
        $this->authorize('update', $campaignRole);

        $campaignRole->update($request->only('name'));
        return redirect()->route('campaign_roles.index', $campaign)
            ->with('success_raw', __($this->view . '.edit.success', ['name' => $campaignRole->name]));
    }

    public function destroy(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('view', [$campaignRole, $campaign]);
        $this->authorize('delete', $campaignRole);
        $campaignRole->delete();

        return redirect()->route('campaign_roles.index', $campaign)
            ->with('success_raw', __($this->view . '.destroy.success', ['name' => $campaignRole->name]));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function savePermissions(Request $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('view', [$campaignRole, $campaign]);
        $this->authorize('update', $campaignRole);

        $this->service->role($campaignRole)->savePermissions($request->post('permissions', []));

        return redirect()->route('campaign_roles.show', [$campaign, 'campaign_role' => $campaignRole])
            ->with('success', trans('crud.permissions.success'));
    }

    /**
     * campaign/<id>/campaign_roles/admin fast url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function admin(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        $adminRole = $campaign->roles()->where('is_admin', true)->firstOrFail();

        return $this->show($campaign, $adminRole);
    }

    /**
     * campaign/<id>/campaign_roles/admin fast url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function public(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        $adminRole = $campaign->roles()->public()->firstOrFail();

        return $this->show($campaign, $adminRole);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request, Campaign $campaign)
    {
        $this->authorize('members', $campaign);

        $term = $request->get('q', null);
        if (empty($term)) {
            $members = $campaign->roles()->where('is_admin', 0)->where('is_public', 0)->orderBy('name', 'asc')->limit(5)->get();
        } else {
            $members = $campaign->roles()->where('is_admin', 0)->where('is_public', 0)->where('name', 'like', '%' . $term . '%')->limit(5)->get();
        }

        $results = [];
        foreach ($members as $member) {
            $results[] = [
                'id' => $member->id,
                'text' => $member->name
            ];
        }

        return response()->json($results);
    }

    /**
     * Toggle a permission on a role
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Campaign $campaign, CampaignRole $campaignRole, int $entityType, int $action)
    {
        $this->authorize('view', [$campaignRole, $campaign]);
        $this->authorize('update', $campaignRole);

        if (!$campaignRole->is_public) {
            abort(404);
        }

        $enabled = $this->service->role($campaignRole)->toggle($entityType, $action);
        return response()->json([
            'success' => true,
            'status' => $enabled,
            'toast' => __('campaigns/roles.toggle.' . ($enabled ? 'enabled' : 'disabled'), [
                'role' => $campaignRole->name,
                'action' => __('crud.permissions.actions.read'),
                'entities' => EntitySetup::plural($entityType)
            ]),
        ]);
    }

    /**
     */
    public function bulk(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        $action = request()->get('action');
        $models = request()->get('model');
        if (!in_array($action, ['edit', 'delete']) || empty($models)) {
            return redirect()
                ->route('campaign_roles.index', $campaign);
        }
        $count = 0;
        foreach ($models as $id) {
            /** @var CampaignRole|null $role */
            $role = CampaignRole::find($id);
            if ($role === null) {
                continue;
            }

            if ($action === 'delete' && !$role->isAdmin() && !$role->isPublic()) {
                $role->delete();
                $count++;
            }
        }

        return redirect()
            ->route('campaign_roles.index', $campaign)
            ->with('success', trans_choice('campaigns.roles.bulks.' . $action, $count, ['count' => $count]));
    }
}
