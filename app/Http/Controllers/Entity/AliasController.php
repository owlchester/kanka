<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityAlias;
use App\Http\Requests\StoreEntityLink;
use App\Models\Entity;
use App\Models\EntityAlias;
use App\Models\EntityLink;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AliasController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    public function __construct()
    {
        $this->middleware('campaign.boosted', ['except' => 'create']);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Entity $entity)
    {
        return redirect()
            ->route('entities.assets', $entity);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->boosted()) {
            return view('entities.pages.aliases.unboosted');
        }

        return view('entities.pages.aliases.create', compact(
            'entity'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEntityAlias $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['name', 'visibility_id']);
        $data['entity_id'] = $entity->id;

        $link = EntityAlias::create($data);

        return redirect()
            ->route('entities.assets', $entity)
            ->with('success', __('entities/aliases.create.success', ['name' => $link->name, 'entity' => $entity->name]));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, EntityAlias $entityAlias)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.aliases.update', compact(
            'entity',
            'entityAlias'
        ));
    }

    /**
     * Show exists but doesn't do anything, redirect to main view
     * @param Entity $entity
     * @param EntityLink $entityLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Entity $entity, EntityAlias $entityAlias)
    {
        return redirect()
            ->route('entities.assets', $entity);
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreEntityAlias $request, Entity $entity, EntityAlias $entityAlias)
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
            ->route('entities.assets', $entity)
            ->with('success', __('entities/aliases.update.success', ['name' => $entityAlias->name, 'entity' => $entity->name]));

    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Entity $entity, EntityAlias $entityAlias)
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
            ->route('entities.assets', $entity)
            ->with('success', __('entities/aliases.destroy.success', ['name' => $entityAlias->name, 'entity' => $entity->name]));

    }
}
