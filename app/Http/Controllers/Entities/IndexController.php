<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use Illuminate\Support\Collection;

class IndexController extends Controller
{
    public function index(Campaign $campaign, EntityType $entityType)
    {
        $models = Entity::inTypes($entityType->id)->paginate();

        return view('entities.index.index')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('models', $models)
            ->with('mode', 'grid')
            ->with('forceMode', 'grid')
            ->with('nestable', false)
            ->with('templates', $this->loadTemplates($campaign, $entityType))
        ;
    }


    protected function loadTemplates(Campaign $campaign, EntityType $entityType): Collection
    {
        // No valid user, or invalid entity type (ie relations)
        if (auth()->guest()) {
            return new Collection();
        } elseif (!auth()->user()->can('create', [$entityType, $campaign])) {
            return new Collection();
        }
        return Entity::select('id', 'name', 'entity_id')
            ->templates($entityType->id)
            ->orderBy('name')
            ->get();
    }
}
