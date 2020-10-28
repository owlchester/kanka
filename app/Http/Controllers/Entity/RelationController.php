<?php

namespace App\Http\Controllers\Entity;

use App\Datagrids\Sorters\EntityRelationSorter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelation;
use App\Models\Entity;
use App\Models\Relation;
use App\Models\MiscModel;
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

    /**
     * RelationController constructor.
     * @param EntityRelationService $entityRelationService
     */
    public function __construct(EntityRelationService $entityRelationService)
    {
        $this->service = $entityRelationService;
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

        $ajax = request()->ajax();
        $relations = $entity
            ->relationships()
            ->select('relations.*')
            ->with('target')
            ->has('target')
            ->leftJoin('entities as t', 't.id', '=', 'relations.target_id')
            ->acl()
            ->simpleSort($datagridSorter)
            ->paginate();

        return view('entities.pages.relations.index', compact(
            'ajax',
            'entity',
            'relations',
            'datagridSorter'
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

        return view('entities.pages.relations.create', compact(
            'entity',
            'ajax'
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
        $ajax = $request->ajax();

        /** @var Relation $relation */
        $relation = new Relation();
        $relation = $relation->create($data);

        if ($request->has('two_way')) {
            $relation->createMirror();
        }

        return redirect()
            ->route('entities.relations.index', $entity)
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

        return view('entities.pages.relations.update', compact(
            'entity',
            'relation',
            'ajax',
            'from'
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
        $ajax = $request->ajax();

        $relation->update($data);
        $relation->refresh();

        if (request()->has('from')) {
            $from = (int) request()->post('from');
            if (!empty($from)) {
                return redirect()
                    ->route('entities.relations.index', $from)
                    ->with('success', trans('entities/relations' . '.update.success', [
                        'target' => $relation->target->name,
                        'entity' => $entity->name
                    ]));
            }
        }

        return redirect()
            ->route('entities.relations.index', $entity)
            ->with('success', trans('entities/relations' . '.update.success', [
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
    public function map(Entity  $entity)
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

        $map = $this->service->entity($entity)->map();
        return response()->json(
            $map
        );
    }
}
