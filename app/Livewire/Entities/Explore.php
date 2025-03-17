<?php

namespace App\Livewire\Entities;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\FilterService;
use App\Traits\Livewire\CampaignAware;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Explore extends Component
{
    use CampaignAware;
    use WithPagination;

    public EntityType $entityType;
    public Campaign $campaign;
    public bool $nested;
    public Entity $parent;
    protected FilterService $filterService;
    public int $unfilteredCount = 0;


    public function mount(EntityType $entityType, Campaign $campaign, bool $nested)
    {
        $this->entityType = $entityType;
        $this->campaign = $campaign;
        $this->nested = $nested;
    }

    public function render()
    {
        $this->setCampaign();
        return view('livewire.entities.explore', [
            'entities' => $this->fetchEntities(),
        ]);
    }

    protected function fetchEntities(): LengthAwarePaginator
    {
        $this->filterService = app()->make(FilterService::class);
        $base = Entity::inTypes($this->entityType->id)
            ->select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private',
                'entities.type_id', 'entities.parent_id',
                'entities.image_uuid', 'entities.focus_x', 'entities.focus_y'
            ])
            ->with(['entityType', 'image'])
            ->withCount('children')
            ->search($this->filterService->search())
            ->order($this->filterService->order())
            ->distinct()
        ;

        $parent = null;
        if (isset($this->parent)) {
            // Validate the parent
            $parent = Entity::select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private',
                'entities.type_id', 'entities.parent_id',
                'entities.image_uuid', 'entities.focus_x', 'entities.focus_y'
            ])
                ->inTypes([$this->entityType->id])->where('id', $this->parent->id)->first();
            if ($parent) {
                $base->where('entities.parent_id', $parent->id);
            }
        }
        if (empty($parent) && $this->nested && $this->filterService->activeFiltersCount() === 0) {
            $base->whereNull('entities.parent_id');
        }

        if ($this->filterService->hasFilters()) {
            $this->unfilteredCount = $base->count();
            $base = $base->filter($this->filterService->filters());
        }
        $models = $base->orderBy('name')->paginate(2);
        return $models;
    }

//    #[On('selected')]
//    public function selectParent(Entity $parent)
//    {
//        dd('yoooo');
//        $this->parent = $parent;
//    }

    public function toParent()
    {
        // If the parent is top level, unset it
        if (empty($this->parent->parent)) {
            unset($this->parent);
        }
        $this->parent = $this->parent->parent;
    }
}
