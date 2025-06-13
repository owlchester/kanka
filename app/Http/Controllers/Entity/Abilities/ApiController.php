<?php

namespace App\Http\Controllers\Entity\Abilities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Abilities\AbilityService;

class ApiController extends Controller
{
    protected AbilityService $service;

    public function __construct(AbilityService $service)
    {
        $this->service = $service;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        if (auth()->check()) {
            $this->service->user(auth()->user());
        }

        return response()->json([
            'data' => $this->service
                ->campaign($campaign)
                ->entity($entity)
                ->get(),
        ]);
    }
}
