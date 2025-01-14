<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\TranslatableException;
use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\MoveEntity as Request;
use App\Services\Entity\MoveService;

class EntityMoveApiController extends ApiController
{
    protected MoveService $service;

    public function __construct(MoveService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transfer(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $count = 0;
        $copy = $request->has('copy');
        try {
            foreach ($request->entities as $id) {
                $entity = Entity::find($id);
                if ($this->authorize('update', $entity)) {
                    $this->service
                        ->entity($entity)
                        ->campaign($campaign)
                        ->user($request->user())
                        ->to($request->campaign_id)
                        ->copy($copy)
                        ->validate()
                        ->process()
                    ;
                    $count++;
                }
            }

            if ($copy) {
                return response()->json(['success' => 'Succesfully copied ' . $count . ' entities.']);
            }
            return response()->json(['success' => 'Succesfully transfered ' . $count . ' entities.']);
        } catch (TranslatableException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getTranslatedMessage(),
            ]);
        }

    }
}
