<?php

namespace App\Http\Controllers\Entities;

use App\Facades\FormCopy;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomEntity;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\AttributeService;
use App\Services\Entity\CopyService;
use Illuminate\Http\Request;
use LogicException;

class CreateController extends Controller
{
    public function __construct(
        protected CopyService $copyService,
        protected AttributeService $attributeService
    ) {

    }
    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', [$entityType, $campaign]);

        $tabCopy = false;
        $source = null;
        if ($request->filled('copy')) {
            $source = Entity::inTypes([$entityType->id])->find($request->get('copy'));
            if ($source) {
                FormCopy::source($source);
                $tabCopy = true;
            }
        }

        return view('entities.forms.create')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('tabCopy', $tabCopy)
            ->with('source', $source)
        ;
    }

    public function store(StoreCustomEntity $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', [$entityType, $campaign]);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;

        try {
            /** @var Entity $entity */
            $entity = new Entity($data);
            $entity->type_id = $entityType->id;
            $entity->save();
            $entity->crudSaved();

            // First copy stuff like posts, since we might replace attribute mentions next
            $this->copyService->entity($entity)->request($request)->fromId()->copy();

            if (auth()->user()->can('attributes', $entity)) {
                $this->attributeService
                    ->campaign($campaign)
                    ->entity($entity)
                    ->save($request->get('attribute', []));

                // When copying an entity, the user probably wants to update all mentions of attributes to ones on the new entity.
                if ($request->has('replace_mentions') && $request->filled('replace_mentions') && $entity->isFillable('entry')) {
                    $this->attributeService
                        ->replaceMentions((int) $request->post('copy_source_id'));
                }
            }



            $link = '<a href="' . route(
                'entities.show',
                [$campaign, $entity]
            )
                . '">' . $entity->name . '</a>';
            $success = __('general.success.created', [
                'name' => $link
            ]);

            session()->flash('success_raw', $success);

            if ($request->has('submit-new')) {
                $route = route('entities.create', [$campaign, $entityType]);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-update')) {
                $route = route('entities.edit', [$campaign, $entity]);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-view') && $entity) {
                $route = route('entities.show', [$campaign, $entity]);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-copy')) {
                $route = route('entities..create', [$campaign, $entityType, 'copy' => $entity->id]);
                return response()->redirectTo($route);
            }

            $route = route('entities.show', [$campaign, $entity]);
            return response()->redirectTo($route);

        } catch (LogicException $exception) {
            if (app()->isLocal()) {
                throw $exception;
            }
            $error =  str_replace(' ', '_', mb_strtolower($exception->getMessage()));
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('crud.errors.' . $error));
        }
    }
}
