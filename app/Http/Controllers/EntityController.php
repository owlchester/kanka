<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Http\Requests\CopyEntityToCampaignRequest;
use App\Http\Requests\CreateEntityRequest;
use App\Http\Requests\MoveEntityRequest;
use App\Models\Entity;
use App\Services\EntityService;
use Illuminate\Support\Facades\Auth;

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
     */
    public function move(Entity $entity)
    {
        $this->authorize('move', $entity->child);

        $entities = $this->entityService->labelledEntities(true, [$entity->pluralType(), 'menu_links'], true);
        return view('cruds.move', ['entity' => $entity, 'entities' => $entities]);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copyToCampaign(Entity $entity)
    {
        $this->authorize('view', $entity->child);

        return view('cruds.copy_to_campaign', [
            'entity' => $entity,
            'campaigns' => Auth::user()->moveCampaignList(false)
        ]);
    }

    /**
     * @param CopyEntityToCampaignRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function copyEntityToCampaign(CopyEntityToCampaignRequest $request, Entity $entity)
    {
        $this->authorize('view', $entity->child);

        try {
            $options = $request->only('campaign');
            $options['copy'] = 'on';

            $entity = $this->entityService->move($entity, $options);

            return redirect()->route($entity->pluralType() . '.show', $entity->entity_id)
                ->with('success', trans('crud.move.success_copy', ['name' => $entity->name]));
        } catch (TranslatableException $ex) {
            return redirect()->route($entity->pluralType() . '.show', $entity->entity_id)
                ->with('error', trans($ex->getMessage(), ['name' => $entity->name]));
        }
    }

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function export(Entity $entity)
    {
        $realEntity = $entity;
        $pdf = \App::make('dompdf.wrapper');
        $entities = [$realEntity->child];
        $name = $realEntity->pluralType();
        $entity = $realEntity->pluralType();
        $exporting = true; // This can be used in views to know we are exporting
        $datagridSorter = null;

        if (request()->has('html')) {
            return view('cruds.export', compact(
                'entity',
                'name',
                'entities',
                'exporting'
            ));
        }

        return $pdf
            ->loadView('cruds.export', compact('entity', 'name', 'entities', 'exporting', 'datagridSorter'))
            ->download('kanka ' . strip_tags($realEntity->name) . ' export.pdf');
    }

    /**
     * @param MoveEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(MoveEntityRequest $request, Entity $entity)
    {
        $this->authorize('move', $entity->child);

        try {
            $entity = $this->entityService->move($entity, $request->only('target', 'campaign', 'copy'));

            if ($entity->child->campaign_id != Auth::user()->campaign->id) {
                if ($request->has('copy')) {
                    return redirect()->route($entity->pluralType() . '.index')
                        ->with('success', trans('crud.move.success_copy', ['name' => $entity->name]));
                }
                return redirect()->route($entity->pluralType() . '.index')
                ->with('success', trans('crud.move.success', ['name' => $entity->name]));
            }
            return redirect()->route($entity->pluralType() . '.show', $entity->entity_id)
            ->with('success', trans('crud.move.success', ['name' => $entity->name]));
        } catch (TranslatableException $ex) {
            return redirect()->route($entity->pluralType() . '.show', $entity->entity_id)
            ->with('error', trans($ex->getMessage(), ['name' => $entity->name]));
        }
    }

    /**
     * @param CreateEntityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateEntityRequest $request)
    {
        $entity = $this->entityService->create($request->post('name'), $request->post('target'));
        return response()->json([
            'id' => $entity->id,
            'name' => $entity->name
        ]);
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
        $entity = $this->entityService->toggleTemplate($entity);
        return redirect()->back()
            ->with(
                'success',
                __('entities/actions.templates.success.' . ($entity->is_template ? 'set' : 'unset'), ['name' => $entity->name])
            );
    }
}
