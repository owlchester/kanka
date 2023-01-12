<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Services\Families\FamilyTreeService;
use App\Traits\GuestAuthTrait;

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

    public function api(Family $family)
    {
        return response()->json(
            $this
                ->service
                ->family($family)
                ->api()
        );
    }
}
