<?php

namespace App\Http\Controllers\Entity;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelation;
use App\Http\Resources\Web\EntityResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Relation;
use App\Services\Entity\Connections\RelatedService;
use App\Services\Entity\RelationService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class RelationController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected RelatedService $connectionService;

    protected RelationService $relationService;

    public function __construct(RelatedService $connectionService, RelationService $relationService)
    {
        $this->connectionService = $connectionService;
        $this->relationService = $relationService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        $mode = request()->get('mode', null);
        if (! in_array($mode, ['map', 'table'])) {
            $mode = null;
        }

        $option = request()->get('option', null);
        if (! in_array($option, ['related', 'mentions', 'only_relations'])) {
            $option = null;
        }

        $order = request()->get('order', null);

        $rows = $connections = $connectionService = [];
        // @phpstan-ignore-next-line
        $defaultToTable = ! $campaign->boosted() || ($campaign->boosted() && $campaign->defaultToConnection());
        if ($mode == 'table' || (empty($mode) && $defaultToTable)) {
            $mode = 'table';

            Datagrid::layout(\App\Renderers\Layouts\Entity\Relation::class)
                ->route('entities.relations_table', ['campaign' => $campaign, 'entity' => $entity, 'mode' => 'table']);

            $rows = $entity
                ->allRelationships()
                ->sort(request()->only(['o', 'k']))
                ->with(['owner', 'target', 'target.location', 'target.location.entity'])
                ->paginate()
                ->withPath(route('entities.relations_table', ['campaign' => $campaign, 'entity' => $entity, 'mode' => 'table']));

            $connections = $this->connectionService
                ->entity($entity)
                ->order($order)
                ->connections();

            $connectionService = $this->connectionService;
        }
        // @phpstan-ignore-next-line
        $defaultToMap = ! $campaign->boosted() || ($campaign->boosted() && $campaign->defaultToConnectionMode());
        if ($mode != 'table' && empty($option) && $defaultToMap) {
            if ($campaign->defaultToConnectionMode() == 1) {
                $option = 'only_relations';
            } elseif ($campaign->defaultToConnectionMode() == 2) {
                $option = 'related';
            } elseif ($campaign->defaultToConnectionMode() == 3) {
                $option = 'mentions';
            }
        }
        $entityTypeId = 'connection';

        return view('entities.pages.relations.index', compact(
            'campaign',
            'entity',
            'entityTypeId',
            'rows',
            'mode',
            'option',
            'connections',
            'connectionService',
            'campaign'
        ));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        $mode = $this->getModeOption();

        return view('entities.pages.relations.create', compact(
            'campaign',
            'entity',
            'mode'
        ));
    }

    public function store(StoreRelation $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->relationService->campaign($campaign)->createRelations($request);

        $mode = $this->getModeOption(true);
        $redirect = [$campaign, $entity];
        if (! empty($mode)) {
            $redirect['mode'] = $mode;
        }

        return redirect()
            ->route('entities.relations.index', $redirect)
            ->with('success', trans_choice('entities/relations.create.success_bulk', $this->relationService->getCount(), [
                'entity' => $entity->name,
                'count' => $this->relationService->getCount(),
            ]));
    }

    // This page doesn't exist, but crawlers will try
    public function show(Campaign $campaign, Entity $entity, Relation $relation)
    {
        abort(404);
    }

    public function edit(Campaign $campaign, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity);

        $from = request()->get('from', 0);
        if ($from !== 'web') {
            $from = (int) $from;
        }
        $mode = $this->getModeOption();

        return view('entities.pages.relations.update', compact(
            'campaign',
            'entity',
            'relation',
            'from',
            'mode'
        ));
    }

    public function update(StoreRelation $request, Campaign $campaign, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity);
        $data = $request->only(['target_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id']);

        if ($request->unmirror && $relation->mirror) {
            $relation->mirror->update(['mirror_id' => null]);
            $data['mirror_id'] = null;
        }

        $relation->update($data);
        $relation->refresh();
        $mode = $this->getModeOption();

        if (request()->has('from')) {
            $from = request()->post('from');
            if ($from === 'web') {
                return response()
                    ->json([
                        'updated' => true,
                        'id' => $relation->id,
                        'colour' => $relation->colour,
                        'attitude' => $relation->attitude,
                        'text' => $relation->relation,
                        'target' => (new EntityResource($relation->target))->campaign($campaign),
                    ]);
            }
            elseif (! empty($from)) {
                $redirect = [$campaign, (int) $from];
                if (! empty($mode)) {
                    $redirect['mode'] = $mode;
                }
                if (request()->has('option')) {
                    $redirect['option'] = request()->get('option');
                }

                return redirect()
                    ->route('entities.relations.index', $redirect)
                    ->with('success', trans('entities/relations' . '.update.success', [
                        'target' => $relation->target->name,
                        'entity' => $entity->name,
                    ]));
            }
        }

        $redirect = [$campaign, $entity];
        if (! empty($mode)) {
            $redirect['mode'] = $mode;
        }
        if (request()->has('option')) {
            $redirect['option'] = request()->get('option');
        }

        return redirect()
            ->route('entities.relations.index', $redirect)
            ->with('success', __('entities/relations' . '.update.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name,
            ]));
    }

    public function destroy(Campaign $campaign, Entity $entity, Relation $relation)
    {
        $this->authorize('update', $entity);

        if (request()->has('mode')) {
            $mode = request()->get('mode');
        } else {
            $mode = $this->getModeOption();
        }

        $deletedMirror = false;
        if (request()->get('remove_mirrored') === '1' && $relation->isMirrored()) {
            $mirror = $relation->mirror;
            if (! empty($mirror) && auth()->user()->can('relation', [$relation->target, 'delete'])) {
                $mirror->delete();
                $deletedMirror = true;
            }
        }

        // Update the mirror to remove it's mirrored status
        if ($deletedMirror === false && $relation->isMirrored()) {
            $mirror = $relation->mirror;
            $mirror->update([
                'mirror_id' => null,
            ]);
        }

        $relation->delete();
        $redirect = [$campaign, $entity];
        if (! empty($mode)) {
            $redirect['mode'] = $mode;
        }
        if (request()->has('option')) {
            $redirect['option'] = request()->get('option');
        }
        if (request()->get('from') === 'web') {
            return response()
                ->json(['deleted' => true, 'id' => $relation->id]);
        }

        return redirect()
            ->route('entities.relations.index', $redirect)
            ->with('success', trans('entities/relations.destroy.success', [
                'target' => $relation->target->name,
                'entity' => $entity->name,
            ]));
    }

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
