<?php

namespace App\Http\Controllers\Entity;

use App\Datagrids\Sorters\EntityRelationSorter;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelation;
use App\Models\Entity;
use App\Models\Relation;
use App\Models\MiscModel;
use App\Services\Entity\ConnectionService;
use App\Services\Entity\EntityRelationService;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /**
     * @var
     */
    protected $transKey;

    /**
     * @var
     */
    protected $viewPath;

    /** @var EntityRelationService */
    protected $service;

    /** @var ConnectionService */
    protected $connectionService;

    /**
     * RelationController constructor.
     * @param EntityRelationService $entityRelationService
     */
    public function __construct(EntityRelationService $entityRelationService, ConnectionService $connectionService)
    {
        $this->service = $entityRelationService;
        $this->connectionService = $connectionService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        $datagridSorter = new EntityRelationSorter();
        $datagridSorter->request(request()->all());
        $campaign = CampaignLocalization::getCampaign();

        $mode = request()->get('mode', null);
        if (!in_array($mode, ['map', 'table'])) {
            $mode = null;
        }

        $option = request()->get('option', null);
        if (!in_array($option, ['related', 'mentions'])) {
            $option = null;
        }

        $order = request()->get('order', null);

        $ajax = request()->ajax();

        $relations = $connections = $connectionService = [];
        $defaultToTable = !$campaign->boosted() || ($campaign->boosted() && $campaign->defaultToConnection());
        if ($mode == 'table' || (empty($mode) && $defaultToTable)) {
            $mode = 'table';
            $relations = $entity
                ->allRelationships()
                ->simpleSort($datagridSorter)
                ->paginate();

            $connections = $this->connectionService
                ->entity($entity)
                ->order($order)
                ->connections();

            $connectionService = $this->connectionService;
        }

        return view('entities.pages.relations.index', compact(
            'ajax',
            'entity',
            'relations',
            'datagridSorter',
            'mode',
            'option',
            'connections',
            'connectionService'
        ));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $ajax = request()->ajax();
        $mode = $this->getModeOption();

        return view('entities.pages.relations.create', compact(
            'entity',
            'ajax',
            'mode'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRelation $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only([
            'owner_id', 'target_id', 'attitude', 'relation', 'colour', 'is_star', 'two_way', 'visibility'
        ]);

        /** @var Relation $relation */
        $relation = new Relation();
        $relation = $relation->create($data);

        if ($request->has('two_way')) {
            $relation->createMirror();
        }

        $mode = $this->getModeOption(true);
        $redirect = [$entity];
        if (!empty($mode)) {
            $redirect['mode'] = $mode;
        }

        return redirect()
            ->route('entities.relations.index', $redirect)
            ->with('success', trans('entities/relations.create.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name
            ]));
    }

    // This page doesn't exist, but crawlers will try
    public function show(Entity $entity, Relation $relation)
    {
        abort(404);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);

        $ajax = request()->ajax();
        $from = (int) request()->get('from', 0);
        $mode = $this->getModeOption();

        return view('entities.pages.relations.update', compact(
            'entity',
            'relation',
            'ajax',
            'from',
            'mode'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreRelation $request, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['target_id', 'attitude', 'relation', 'colour', 'is_star', 'two_way', 'visibility']);

        $relation->update($data);
        $relation->refresh();
        $mode = $this->getModeOption();

        if (request()->has('from')) {
            $from = (int) request()->post('from');
            if (!empty($from)) {
                $redirect = [$from];
                if (!empty($mode)) {
                    $redirect['mode'] = $mode;
                }

                return redirect()
                    ->route('entities.relations.index', $redirect)
                    ->with('success', trans('entities/relations' . '.update.success', [
                        'target' => $relation->target->name,
                        'entity' => $entity->name
                    ]));
            }
        }


        $redirect = [$entity];
        if (!empty($mode)) {
            $redirect['mode'] = $mode;
        }
        return redirect()
            ->route('entities.relations.index', $redirect)
            ->with('success', __('entities/relations' . '.update.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name
            ]));
    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);

        $deletedMirror = false;
        if (request()->get('remove_mirrored') === '1' && $relation->mirrored()) {
            $mirror = $relation->mirror;
            if (!empty($mirror) && auth()->user()->can('relation', [$relation->target->child, 'delete'])) {
                $mirror->delete();
                $deletedMirror = true;
            }
        }

        // Update the mirror to remove it's mirrored status
        if ($deletedMirror === false && $relation->mirrored()) {
            $mirror = $relation->mirror;
            $mirror->update([
                'mirror_id' => null
            ]);
        }

        $relation->delete();

        return redirect()
            ->route('entities.relations.index', [$entity->id])
            ->with('success', trans('entities/relations.destroy.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name
            ]));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function map(Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        $map = $this->service->entity($entity)
            ->option(request()->get('option', null))
            ->map();
        return response()->json(
            $map
        );
    }

    /**
     * @return mixed|null
     */
    protected function getModeOption(bool $post = false)
    {
        $mode = request()->get('mode');
        if ($post) {
            $mode = request()->post('mode');
        }
        if (in_array($mode, ['mode', 'table'])) {
            return $mode;
        }
        return null;
    }
}
