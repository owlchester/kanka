<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TemplateService;

class TemplateController extends Controller
{
    protected TemplateService $service;

    public function __construct(TemplateService $templateService)
    {
        $this->middleware('auth');
        $this->service = $templateService;
    }

    public function update(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        $this->authorize('setTemplates', $campaign);

        if (request()->ajax()) {
            return response()->json();
        }

        $this->service->entity($entity)->toggle();

        if ($entity->isTemplate()) {
            session()->flash('success_docs', 'guides/archetypes');
        }

        return redirect()->back()
            ->with(
                'success_raw',
                __('entries/archetypes.success.' . ($entity->isTemplate() ? 'set' : 'unset'), ['name' => $entity->name])
            );
    }
}
