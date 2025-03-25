<?php

namespace App\Http\Controllers\Entity\Connections;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\GuestAuthTrait;

class TableController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        Datagrid::layout(\App\Renderers\Layouts\Entity\Relation::class)
            ->route('entities.relations_table', ['campaign' => $campaign, 'entity' => $entity, 'mode' => 'table']);

        $this->rows = $entity
            ->allRelationships()
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        // $this->campaign($campaign)->datagrid();

        $html = view('layouts.datagrid._table')
            ->with('rows', $this->rows)
            ->with('campaign', $campaign)
            ->render();
        $data = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($data);
    }
}
