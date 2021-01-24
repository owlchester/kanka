<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\MenuLink;
use App\Http\Requests\StoreMenuLink as Request;
use App\Http\Resources\MenuLinkResource as Resource;

class MenuLinkApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->menuLinks()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param MenuLink $menuLink
     * @return Resource
     */
    public function show(Campaign $campaign, MenuLink $menuLink)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $menuLink);
        return new Resource($menuLink);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', MenuLink::class);
        $model = MenuLink::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param MenuLink $menuLink
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, MenuLink $menuLink)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $menuLink);
        $menuLink->update($request->all());
        $this->crudSave($menuLink);

        return new Resource($menuLink);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param MenuLink $menuLink
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, MenuLink $menuLink)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $menuLink);
        $menuLink->delete();

        return response()->json(null, 204);
    }
}
