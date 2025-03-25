<?php

namespace App\Http\Controllers\Entity\Abilities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Services\Abilities\ChargeService;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    protected ChargeService $service;

    public function __construct(ChargeService $chargeService)
    {
        $this->service = $chargeService;
    }

    public function use(Request $request, Campaign $campaign, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('update', $entity);

        return response()->json([
            'success' => $this->service
                ->entity($entity)
                ->ability($entityAbility)
                ->use((int) $request->post('used')),
        ]);
    }

    public function reset(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        $this->service
            ->entity($entity)
            ->reset();

        return redirect()->route('entities.entity_abilities.index', [$campaign, $entity])
            ->withSuccess(__('entities/abilities.recharge.success'));
    }
}
