<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\ExportService;
use App\Traits\GuestAuthTrait;

/**
 * Class ExportController
 * @package App\Http\Controllers\Entity
 */
class ExportController extends Controller
{
    use GuestAuthTrait;

    protected ExportService $service;

    public function __construct(ExportService $service)
    {
        $this->service = $service;
    }

    public function json(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);

        return $this->service->entity($entity)->json();
    }

    public function html(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);

        return view('entities.pages.print.print')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('model', $entity->child)
            ->with('name', $entity->pluralType())
            ->with('printing', true)
        ;
    }
}
