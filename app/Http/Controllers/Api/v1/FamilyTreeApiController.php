<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Middleware\Campaigns\Premium;
use App\Http\Requests\StoreFamilyTree as Request;
use App\Http\Resources\FamilyTreeResource as Resource;
use App\Models\Campaign;
use App\Models\Family;
use App\Services\Families\FamilyTreeService;

class FamilyTreeApiController extends ApiController
{
    protected FamilyTreeService $treeService;

    public function __construct(FamilyTreeService $treeService)
    {
        $this->treeService = $treeService;
        $this->middleware(Premium::class, ['except' => ['show']]);
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $family->entity);

        return new Resource($family->familyTree);
    }

    /**
     * @return resource | \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $family->entity);

        if (! $campaign->premium()) {
            return response()->json('You need to activate premium functions on the campaign to use this feature', 204);
        }

        $data = $request->input('tree');

        $model = $this
            ->treeService
            ->family($family)
            ->user($request->user())
            ->save($data)
            ->familyTree();

        return new Resource($model);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $family->entity);

        if ($family->familyTree) {
            $family->familyTree->delete();
        }

        return response()->json(null, 204);
    }
}
