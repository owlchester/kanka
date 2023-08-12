<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityAlias;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityAlias;

class AliasController extends Controller
{
    public function __construct()
    {
        $this->middleware('campaign.boosted', ['except' => 'create']);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity]);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        if (!$campaign->boosted()) {
            return view('entities.pages.aliases.unboosted')
                ->with('campaign', $campaign);
        }

        return view('entities.pages.aliases.create', compact(
            'campaign',
            'entity'
        ));
    }

    /**
     */
    public function store(StoreEntityAlias $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['name', 'visibility_id']);
        $data['entity_id'] = $entity->id;

        /** @var EntityAlias $link */
        $link = EntityAlias::create($data);

        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity])
            ->with('success', __('entities/aliases.create.success', ['name' => $link->name, 'entity' => $entity->name]));
    }

    /**
     */
    public function edit(Campaign $campaign, Entity $entity, EntityAlias $entityAlias)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.aliases.update', compact(
            'campaign',
            'entity',
            'entityAlias'
        ));
    }

    /**
     * Show exists but doesn't do anything, redirect to main view
     */
    public function show(Campaign $campaign, Entity $entity, EntityAlias $entityAlias)
    {
        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity]);
    }

    /**
     */
    public function update(StoreEntityAlias $request, Campaign $campaign, Entity $entity, EntityAlias $entityAlias)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['name', 'visibility_id']);

        $entityAlias->update($data);

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity])
            ->with('success', __('entities/aliases.update.success', ['name' => $entityAlias->name, 'entity' => $entity->name]));
    }

    /**
     */
    public function destroy(Campaign $campaign, Entity $entity, EntityAlias $entityAlias)
    {
        $this->authorize('update', $entity->child);

        if (!$entityAlias->delete()) {
            abort(500);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()
            ->route('entities.entity_assets.index', [$campaign, $entity])
            ->with('success', __('entities/aliases.destroy.success', ['name' => $entityAlias->name, 'entity' => $entity->name]));
    }
}
