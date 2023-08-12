<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\EntityService;

class TemplateController extends Controller
{
    protected EntityService $entityService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
        $this->entityService = $entityService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
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
