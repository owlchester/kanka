<?php

namespace App\Http\Controllers\Entity\Connections;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\EntityRelationService;
use App\Traits\GuestAuthTrait;

class MapController extends Controller
{
    use GuestAuthTrait;

    protected EntityRelationService $service;

    public function __construct(EntityRelationService $entityRelationService)
    {
        $this->service = $entityRelationService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);

        $map = $this->service
            ->campaign($campaign)
            ->entity($entity)
            ->option(request()->get('option', null))
            ->map();

        return response()->json(
            $map
        );
    }
}
