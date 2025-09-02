<?php

namespace App\Http\Controllers\Entities;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Renderers\Layouts\Entity\Children;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

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
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['parent_id'] = $entity->id;
        }

        /** @var Children $layout */
        $layout = app()->make(Children::class);
        $layout->entityType($entity->entityType);
        Datagrid::layout($layout)
            ->route('entities.children', $options);

        $this->rows = $entity
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'image', 'entityType',
                'tags',
                'children',
                'parent',
            ])
            ->filter($filters)
            ->paginate(config('limits.pagination'));

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
