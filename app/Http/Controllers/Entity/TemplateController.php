<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TemplateService;

class TemplateController extends Controller
{
    protected TemplateService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TemplateService $templateService)
    {
        $this->middleware('auth');
        $this->service = $templateService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $this->authorize('setTemplates', $campaign);

        $this->service->entity($entity)->toggle();
        return redirect()->back()
            ->with(
                'success',
                __('entities/actions.templates.success.' . ($entity->isTemplate() ? 'set' : 'unset'), ['name' => $entity->name])
            );
    }
}
