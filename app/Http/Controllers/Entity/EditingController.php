<?php


namespace App\Http\Controllers\Entity;


use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Services\Entity\MultiEditingService;

class EditingController extends Controller
{
    /** @var MultiEditingService */
    protected $service;

    public function __construct(MultiEditingService $service)
    {
        $this->service = $service;
    }

    public function confirm(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service->entity($entity)
            ->user(auth()->user());

        if (!$this->service->isEditing()) {
            $this->service->edit();
        }

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function keepAlive(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service->entity($entity)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);

    }
}
