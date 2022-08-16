<?php

namespace App\Http\Controllers;

use App\Facades\EntitySetup;
use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Facades\Datagrid;
use App\Models\CampaignRole;
use App\Http\Requests\StoreCampaignRole;
use Illuminate\Http\Request;

class CampaignRoleController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'campaigns.roles';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        Datagrid::layout(\App\Renderers\Layouts\Campaign\CampaignRole::class);

        $this->authorize('roles', $campaign);

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
            $html = view('campaigns.roles._table')->with('rows', $rows)->render();
            $deletes = view('layouts.datagrid.delete-forms')->with('models', Datagrid::deleteForms())->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'deletes' => $deletes,
            ]);
        }

        return view('campaigns.roles', compact('campaign', 'rows', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', CampaignRole::class);
        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('skipImage', true)
                ->with('name', 'campaign_roles');
        }
        $ajax = request()->ajax();

        return view($this->view . '.create', ['model' => $campaign, 'ajax' => $ajax]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRole $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('skipImage', true)
                ->with('name', 'campaign_roles');
        }
        $this->authorize('create', CampaignRole::class);
        $role = CampaignRole::create($request->all());
        return redirect()->route('campaign_roles.index')
            ->with('success_raw', __($this->view . '.create.success', ['name' => $role->name]));
    }

    /**
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(CampaignRole $campaignRole)
    {
        $this->authorize('view', $campaignRole);

        $campaign = CampaignLocalization::getCampaign();
        $members = $campaignRole
            ->users()
            ->with('user')
            ->paginate();

        return view($this->view . '.show', [
            'model' => $campaign,
            'role' => $campaignRole,
            'campaign' => $campaign,
            'members' => $members,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();
        $ajax = request()->ajax();

        return view($this->view . '.edit', [
            'model' => $campaign,
            'role' => $campaignRole,
            'ajax' => $ajax
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignRole $request, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);
        $campaign = CampaignLocalization::getCampaign();

        $campaignRole->update($request->all());
        return redirect()->route('campaign_roles.index')
            ->with('success_raw', __($this->view . '.edit.success', ['name' => $campaignRole->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignRole $campaignRole)
    {
        $this->authorize('delete', $campaignRole);
        $campaignRole->delete();

        return redirect()->route('campaign_roles.index')
            ->with('success_raw', __($this->view . '.destroy.success', ['name' => $campaignRole->name]));
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function savePermissions(Request $request, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);

        $campaignRole->savePermissions($request->post('permissions', []));

        return redirect()->route('campaign_roles.show', ['campaign_role' => $campaignRole])
            ->with('success', trans('crud.permissions.success'));
    }

    /**
     * campaign/<id>/campaign_roles/admin fast url
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function admin()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);

        $adminRole = $campaign->roles()->where('is_admin', true)->firstOrFail();

        return $this->show($adminRole);
    }

    /**
     * campaign/<id>/campaign_roles/admin fast url
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function public()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);

        $adminRole = $campaign->roles()->public()->firstOrFail();

        return $this->show($adminRole);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
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
     * @param CampaignRole $campaignRole
     * @param int $entityType
     * @param int $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(CampaignRole $campaignRole, int $entityType, int $action)
    {
        $this->authorize('update', $campaignRole);

        if (!$campaignRole->is_public) {
            abort(404);
        }

        $enabled = $campaignRole->toggle($entityType, $action);
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
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function bulk()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('roles', $campaign);

        $action = request()->get('action');
        $models = request()->get('model');
        if (!in_array($action, ['edit', 'delete']) || empty($models)) {
            return redirect()
                ->route('campaign_roles.index');
        }
        $count = 0;
        foreach ($models as $id) {
            /** @var CampaignRole $role */
            $role = CampaignRole::find($id);
            if (empty($role)) {
                continue;
            }

            if ($action === 'delete' && !$role->isAdmin() && !$role->isPublic()) {
                $role->delete();
                $count++;
            }
        }

        return redirect()
            ->route('campaign_roles.index')
            ->with('success', trans_choice('campaigns.roles.bulks.' . $action, $count, ['count' => $count]));
    }
}
