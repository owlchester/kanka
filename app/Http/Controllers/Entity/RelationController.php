<?php

namespace App\Http\Controllers\Entity;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelation;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Relation;
use App\Services\Entity\ConnectionService;
use App\Services\Entity\EntityRelationService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    protected $viewPath;

    /** @var EntityRelationService */
    protected EntityRelationService $service;

    /** @var ConnectionService */
    protected ConnectionService $connectionService;

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
    public function index(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }
        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        $mode = request()->get('mode', null);
        if (!in_array($mode, ['map', 'table'])) {
            $mode = null;
        }

        $option = request()->get('option', null);
        if (!in_array($option, ['related', 'mentions', 'only_relations'])) {
            $option = null;
        }

        $order = request()->get('order', null);

        $rows = $connections = $connectionService = [];
        // @phpstan-ignore-next-line
        $defaultToTable = !$campaign->boosted() || ($campaign->boosted() && $campaign->defaultToConnection());
        if ($mode == 'table' || (empty($mode) && $defaultToTable)) {
            $mode = 'table';

            Datagrid::layout(\App\Renderers\Layouts\Entity\Relation::class)
                ->route('entities.relations_table', ['campaign' => $campaign, $entity, 'mode' => 'table']);

            $rows = $entity
                ->allRelationships()
                ->sort(request()->only(['o', 'k']))
                ->paginate()
                ->withPath(route('entities.relations_table', [$campaign, $entity, 'mode' => 'table']));

            $connections = $this->connectionService
                ->entity($entity)
                ->order($order)
                ->connections();

            $connectionService = $this->connectionService;
        }
        // @phpstan-ignore-next-line
        $defaultToMap = !$campaign->boosted() || ($campaign->boosted() && $campaign->defaultToConnectionMode());
        if ($mode != 'table' && empty($option) && $defaultToMap) {
            if ($campaign->defaultToConnectionMode() == 1) {
                $option = 'only_relations';
            } elseif ($campaign->defaultToConnectionMode() == 2) {
                $option = 'related';
            } elseif ($campaign->defaultToConnectionMode() == 3) {
                $option = 'mentions';
            }
        }

        return view('entities.pages.relations.index', compact(
            'campaign',
            'entity',
            'rows',
            'mode',
            'option',
            'connections',
            'connectionService',
            'campaign'
        ));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $mode = $this->getModeOption();

        return view('entities.pages.relations.create', compact(
            'campaign',
            'entity',
            'mode'
        ));
    }

    /**
     * @param StoreRelation $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRelation $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only([
            'owner_id', 'target_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id'
        ]);
        $data['campaign_id'] = $entity->campaign_id;

        $relation = new Relation();
        $relation = $relation->create($data);

        if ($request->has('two_way')) {
            $relation->createMirror();
        }

        $mode = $this->getModeOption(true);
        $redirect = [$campaign, $entity];
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
    public function show(Campaign $campaign, Entity $entity, Relation $relation)
    {
        abort(404);
    }

    /**
     */
    public function edit(Campaign $campaign, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);

        $from = (int) request()->get('from', 0);
        $mode = $this->getModeOption();

        return view('entities.pages.relations.update', compact(
            'campaign',
            'entity',
            'relation',
            'from',
            'mode'
        ));
    }

    /**
     */
    public function update(StoreRelation $request, Campaign $campaign, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);
        $data = $request->only(['target_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id']);

        if ($request->unmirror && $relation->mirror) {
            $relation->mirror->update(['mirror_id' => null]);
            $data['mirror_id'] = null;
        }

        $relation->update($data);
        $relation->refresh();
        $mode = $this->getModeOption();

        if (request()->has('from')) {
            $from = (int) request()->post('from');
            if (!empty($from)) {
                $redirect = [$campaign, $from];
                if (!empty($mode)) {
                    $redirect['mode'] = $mode;
                }
                if (request()->has('option')) {
                    $redirect['option'] = request()->get('option');
                }

                return redirect()
                    ->route('entities.relations.index', $redirect)
                    ->with('success', trans('entities/relations' . '.update.success', [
                        'target' => $relation->target->name,
                        'entity' => $entity->name
                    ]));
            }
        }


        $redirect = [$campaign, $entity];
        if (!empty($mode)) {
            $redirect['mode'] = $mode;
        }
        if (request()->has('option')) {
            $redirect['option'] = request()->get('option');
        }
        return redirect()
            ->route('entities.relations.index', $redirect)
            ->with('success', __('entities/relations' . '.update.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name
            ]));
    }

    /**
     */
    public function destroy(Campaign $campaign, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity->child);

        if (request()->has('mode')) {
            $mode = request()->get('mode');
        } else {
            $mode = $this->getModeOption();
        }

        $deletedMirror = false;
        if (request()->get('remove_mirrored') === '1' && $relation->isMirrored()) {
            $mirror = $relation->mirror;
            if (!empty($mirror) && auth()->user()->can('relation', [$relation->target->child, 'delete'])) {
                $mirror->delete();
                $deletedMirror = true;
            }
        }

        // Update the mirror to remove it's mirrored status
        if ($deletedMirror === false && $relation->isMirrored()) {
            $mirror = $relation->mirror;
            $mirror->update([
                'mirror_id' => null
            ]);
        }

        $relation->delete();
        $redirect = [$campaign, $entity];
        if (!empty($mode)) {
            $redirect['mode'] = $mode;
        }
        if (request()->has('option')) {
            $redirect['option'] = request()->get('option');
        }
        return redirect()
            ->route('entities.relations.index', $redirect)
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
    public function map(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        $map = $this->service
            ->campaign($campaign)
            ->entity($entity)
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

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function table(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        Datagrid::layout(\App\Renderers\Layouts\Entity\Relation::class)
            ->route('entities.relations_table', [$campaign, $entity, 'mode' => 'table']);

        $rows = $entity
            ->allRelationships()
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        $html = view('layouts.datagrid._table')
            ->with('rows', $rows)
            ->with('campaign', $campaign)
            ->render();
        $data = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($data);
    }
}
