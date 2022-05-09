<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityLink;
use App\Models\Entity;
use App\Models\EntityLink;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkController extends Controller
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
            return view('entities.pages.links.unboosted');
        }

        return view('entities.pages.links.create', compact(
            'entity'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEntityLink $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['name', 'url', 'position', 'icon', 'visibility_id']);
        $data['entity_id'] = $entity->id;

        $link = EntityLink::create($data);

        return redirect()
            ->route('entities.assets', $entity)
            ->with('success', __('entities/links.create.success', ['name' => $link->name, 'entity' => $entity->name]));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, EntityLink $entityLink)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.links.update', compact(
            'entity',
            'entityLink'
        ));
    }

    /**
     * Show exists but doesn't do anything, redirect to main view
     * @param Entity $entity
     * @param EntityLink $entityLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Entity $entity, EntityLink $entityLink)
    {
        return redirect()
            ->route('entities.assets', $entity);
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreEntityLink $request, Entity $entity, EntityLink $entityLink)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['name', 'url', 'icon', 'position', 'visibility_id']);

        $entityLink->update($data);

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()
            ->route('entities.assets', $entity)
            ->with('success', __('entities/links.update.success', ['name' => $entityLink->name, 'entity' => $entity->name]));

    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Entity $entity, EntityLink $entityLink)
    {
        $this->authorize('update', $entity->child);

        if (!$entityLink->delete()) {
            abort(500);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
        return redirect()
            ->route('entities.assets', $entity)
            ->with('success', __('entities/links.destroy.success', ['name' => $entityLink->name, 'entity' => $entity->name]));

    }

    /**
     * @param Entity $entity
     * @param EntityLink $entityLink
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function go(Entity $entity, EntityLink $entityLink)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        if ($entityLink->entity_id !== $entity->id) {
            abort(404);
        }

        // If the link goes to the same domain, just go.
        if (Str::startsWith($entityLink->url, config('app.url')) && !Str::contains($entityLink->url, 'entity_links/')) {
            return redirect()->to($entityLink->url);
        }

        return view('entities.pages.links.go', compact(
            'entity',
            'entityLink'
        ));
    }
}
