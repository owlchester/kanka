<?php

namespace App\Http\Controllers\Entities;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Journal;
use App\Models\Quest;
use App\Renderers\Layouts\Entity\Children;
use App\Services\Entity\ColumnDefinitionService;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ChildrenController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        $options = ['campaign' => $campaign, 'entity' => $entity, 'm' => $this->descendantsMode()];
        $optionalColumns = app(ColumnDefinitionService::class)->childrenColumns($entity->entityType, $campaign);

        /** @var Children $layout */
        $layout = app()->make(Children::class);
        $layout->entityType($entity->entityType);
        $layout->campaign($campaign);
        $layout->optionalColumns($optionalColumns);
        Datagrid::layout($layout)
            ->route('entities.children', $options);

        $sortable = ['name', 'type', 'parent.name'];
        foreach ($optionalColumns as $column) {
            if (! empty($column['sortKey'])) {
                $sortable[] = $column['sortKey'];
            }
        }
        $sort = request()->only(['o', 'k']);
        if (! in_array($sort['k'] ?? null, $sortable, true)) {
            $sort = [];
        } elseif (! in_array(mb_strtolower($sort['o'] ?? ''), ['asc', 'desc'], true)) {
            $sort['o'] = 'asc';
        }
        $order = isset($sort['k']) ? [$sort['k'] => mb_strtolower($sort['o'])] : ['name' => 'asc'];

        $query = $entity
            ->descendants()
            ->grid()
            ->order($order)
            ->with([
                'image', 'entityType',
                'status', 'calendarDate.calendar.entity',
                'locations.entity',
                'child' => fn (MorphTo $child) => $child->morphWith([
                    Journal::class => ['author'],
                    Quest::class => ['instigator'],
                ]),
                'tags',
                'children' => fn ($sub) => $sub->grid(),
                'parent' => fn ($sub) => $sub->grid(),
            ]);

        if ($this->filterToDirect()) {
            $query->where('laravel_cte.parent_id', $entity->id);
        }

        $this->rows = $query->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return view('entities.pages.children.index')
            ->with([
                'entity' => $entity,
                'campaign' => $this->campaign,
                'rows' => $this->rows,
                'mode' => $this->descendantsMode(),
            ]);
    }
}
