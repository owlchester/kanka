<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\EntityService;

class TemplateController extends Controller
{
    protected EntityService $entityService;

    public function __construct(EntityService $entityService)
    {
        $this->middleware('auth');
        $this->entityService = $entityService;
    }

    /**
     * Set or unset an entity as a template
     */
    public function update(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $entity = $this->entityService->toggleTemplate($entity);

        return redirect()->back()
            ->with(
                'success',
                __('entities/actions.templates.success.' . ($entity->is_template ? 'set' : 'unset'), ['name' => $entity->name])
            );
    }
}
