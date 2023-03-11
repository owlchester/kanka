<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Family;
use App\Services\Families\FamilyTreeService;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\JsonResponse;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class FamilyTreeController extends Controller
{
    use GuestAuthTrait;

    protected FamilyTreeService $service;

    public function __construct(FamilyTreeService $service)
    {
        $this->service = $service;
    }

    public function index(Family $family)
    {
        if (auth()->check()) {
            $this->authorize('view', $family);
        } else {
            $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $family);
        }

        $mode = request()->has('vue') ? 'vue' : 'pixi';

        return view('families.trees.index')
            ->with('family', $family)
            ->with('mode', $mode)
        ;
    }

    /**
     * Provide the family tree info as a json
     */
    public function api(Family $family): JsonResponse
    {
        if (auth()->check()) {
            $this->authorize('view', $family);
        } else {
            $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $family);
        }

        return response()->json(
            $this
                ->service
                ->family($family)
                ->api()
        );
    }

    /**
     * Provide the entity info as a json
     */
    public function entity(Entity $entity): JsonResponse
    {
        if (empty($entity->child)) {
            abort(404);
        }
        $this->authorize('view', $entity->child);

        return response()->json(
            $this
                ->service
                ->entity($entity)
        );
    }

    /**
     * Save the new config
     */
    public function save(Request $request, Family $family): JsonResponse
    {
        //dd($request->get('data'));
        return response()->json(
            $this
                ->service
                ->family($family)
                ->save($request->get('data'))
                ->api()
        );
    }
}
