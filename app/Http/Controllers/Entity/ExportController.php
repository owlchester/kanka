<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Services\Entity\ExportService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

/**
 * Class ExportController
 * @package App\Http\Controllers\Entity
 */
class ExportController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /** @var ExportService */
    protected $service;

    /**
     * ExportController constructor.
     * @param ExportService $service
     */
    public function __construct(ExportService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function json(Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        return $this->service->entity($entity)->json();

    }
}
