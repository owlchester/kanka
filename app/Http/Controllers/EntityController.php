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
     * PDF export
     * @param Entity $entity
     * @return mixed
     */
    public function export(Entity $entity)
    {
        $realEntity = $entity;
        $pdf = \App::make('dompdf.wrapper');
        $entities = [$realEntity->child];
        $name = $realEntity->pluralType();
        $entityType = $realEntity->pluralType();
        $exporting = true; // This can be used in views to know we are exporting
        $datagridSorter = null;

        if (request()->has('html')) {
            return view('cruds.export', compact(
                'entityType',
                'name',
                'entities',
                'exporting'
            ));
        }

        //return view('cruds.export', compact('entity', 'name', 'entities', 'exporting', 'datagridSorter'));

        return $pdf
            ->loadView('cruds.export', compact('entityType', 'name', 'entities', 'exporting', 'datagridSorter'))
            ->download('kanka ' . strip_tags($realEntity->name) . ' export.pdf');
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
