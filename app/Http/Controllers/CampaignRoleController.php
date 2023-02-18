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
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);
        Datagrid::layout(\App\Renderers\Layouts\Campaign\CampaignRole::class)
            ->route('campaign_roles.index', ['campaign' => $campaign]);


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
            $html = view('layouts.datagrid._table')->with('rows', $rows)->render();
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('skipImage', true)
                ->with('name', 'campaign_roles');
        }
        $ajax = request()->ajax();

        return view($this->view . '.create', ['campaign' => $campaign, 'model' => $campaign, 'ajax' => $ajax]);
    }

    /**
     * @param StoreCampaignRole $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaignRole $request, Campaign $campaign)
    {
        $this->authorize('roles', $campaign);
        if (!$campaign->canHaveMoreRoles()) {
            return view('cruds.forms.limit')
                ->with('key', 'roles')
                ->with('skipImage', true)
                ->with('name', 'campaign_roles');
        }
        $role = new CampaignRole($request->all());
        $role->campaign_id = $campaign->id;
        $role->save();
        return redirect()->route('campaign_roles.index', $campaign)
            ->with('success_raw', __($this->view . '.create.success', ['name' => $role->name]));
    }

    /**
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('roles', $campaign);
        if ($campaign->id !== $campaignRole->campaign_id) {
            return redirect()->route('dashboard', $campaignRole->campaign_id);
        }

        // @phpstan-ignore-next-line
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
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('roles', $campaign);
        if ($campaign->id !== $campaignRole->campaign_id) {
            return redirect()->route('dashboard', $campaignRole->campaign_id);
        }

        return view($this->view . '.edit', [
            'model' => $campaign,
            'campaign' => $campaign,
            'role' => $campaignRole,
        ]);
    }

    /**
     * @param StoreCampaignRole $request
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreCampaignRole $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('roles', $campaign);
        if ($campaign->id !== $campaignRole->campaign_id) {
            return redirect()->route('dashboard', $campaignRole->campaign_id);
        }

        $campaignRole->update($request->all());
        return redirect()->route('campaign_roles.index', $campaign)
            ->with('success_raw', __($this->view . '.edit.success', ['name' => $campaignRole->name]));
    }

    /**
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('roles', $campaign);
        if ($campaign->id !== $campaignRole->campaign_id) {
            return redirect()->route('dashboard', $campaignRole->campaign_id);
        }
        $campaignRole->delete();

        return redirect()->route('campaign_roles.index', $campaign)
            ->with('success_raw', __($this->view . '.destroy.success', ['name' => $campaignRole->name]));
    }



    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function bulk(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        $action = request()->get('action');
        $models = request()->get('model');
        if (!in_array($action, ['edit', 'delete']) || empty($models)) {
            return redirect()
                ->route('campaign_roles.index', $campaign->id);
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
