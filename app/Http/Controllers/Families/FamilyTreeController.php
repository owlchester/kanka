<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Services\Families\FamilyTreeService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Request;

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

        return view('families.trees.index')
            ->with('family', $family)
            ->with('api')
        ;
    }

    /**
     * Provide the family tree info as a json
     * @param Family $family
     * @return \Illuminate\Http\JsonResponse
     */
    public function api(Family $family)
    {
        return response()->json(
            $this
                ->service
                ->family($family)
                ->api()
        );
    }

    /**
     * Save the new config
     * @param Request $request
     * @param Family $family
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request, Family $family)
    {
        return response()->json(
            $this
                ->service
                ->family($family)
                ->save($request->get('data'))
                ->api()
        );
    }
}
