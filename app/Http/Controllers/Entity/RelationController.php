<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelation;
use App\Models\Entity;
use App\Models\Relation;
use App\Models\MiscModel;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
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

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        $ajax = request()->ajax();
        $relations = $entity
            ->relationships()
            ->select('relations.*')
            ->with('target')
            ->leftJoin('entities as t', 't.id', '=', 'relations.target_id')
            ->acl()
            ->order(request()->get('order'))
            ->paginate();

        return view('entities.pages.relations.index', compact(
            'ajax',
            'entity',
            'relations'
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

        $data = $request->only(['owner_id', 'target_id', 'attitude', 'relation', 'is_star', 'two_way', 'visibility']);
        $ajax = $request->ajax();

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

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);

        $ajax = request()->ajax();

        return view('entities.pages.relations.update', compact(
            'entity',
            'relation',
            'ajax'
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

        $data = $request->only(['target_id', 'attitude', 'relation', 'is_star', 'two_way', 'visibility']);
        $ajax = $request->ajax();

        $relation->update($data);
        $relation->refresh();

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

        $relation->delete();

        return redirect()
            ->route('entities.relations.index', [$entity->id])
            ->with('success', trans('entities/relations.destroy.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name
            ]));
    }
}
