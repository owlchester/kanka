<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Family;
use App\Http\Requests\StoreFamilyTree as Request;
use App\Http\Resources\FamilyTreeResource as Resource;
use App\Services\Families\FamilyTreeService;

class FamilyTreeApiController extends ApiController
{
    protected FamilyTreeService $treeService;


    public function __construct(FamilyTreeService $treeService)
    {
        $this->treeService = $treeService;
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $family->entity);
        if (!$campaign->premium()) {
            return response()->json([
                'error' => 'This feature is reserved to premium campaigns.'
            ]);
        }

        return new Resource($family->familyTree);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $family->entity);
        if (!$campaign->premium()) {
            return response()->json([
                'error' => 'This feature is reserved to premium campaigns.'
            ]);
        }

        $data = $request->input('tree');

        $model = $this->treeService->family($family)->save($data)->familyTree();

        return new Resource($model);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $family->entity);
        if (!$campaign->premium()) {
            return response()->json([
                'error' => 'This feature is reserved to premium campaigns.'
            ]);
        }

        if ($family->familyTree) {
            $family->familyTree->delete();
        }

        return response()->json(null, 204);
    }
}
