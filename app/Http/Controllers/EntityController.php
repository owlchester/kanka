<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Services\EntityService;

class EntityController extends Controller
{
    protected $entityService;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function files(Entity $entity)
    {
        $this->authorize('view', $entity->child);

        return view('entities.components._files', compact('entity'));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function template(Entity $entity)
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
