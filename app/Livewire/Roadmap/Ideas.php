<?php

namespace App\Livewire\Roadmap;

use App\Models\Feature;
use App\Services\Roadmap\FeatureChampionService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Ideas extends Component
{
    use WithPagination;

    #[Url]
    public string $search;

    public function open(Feature $feature)
    {
        $this->dispatch('open-idea', idea: $feature->id);
    }

    #[On('feature-champions-updated')]
    public function refreshChampions(): void {}

    public function unchampionActive(FeatureChampionService $service): void
    {
        if (auth()->guest()) {
            return;
        }

        $active = auth()->user()->activeFeatureChampion()->with('feature')->first();
        if (! $active?->feature) {
            return;
        }

        if (! auth()->user()->can('unchampion', $active->feature)) {
            return;
        }

        $service->user(auth()->user())->unchampion($active->feature);
        $this->dispatch('feature-champions-updated');
    }

    public function render()
    {
        $ideas = Feature::approved();
        $activeChampion = null;

        if (auth()->check()) {
            $ideas->with(['uservote', 'userChampion']);
            if (auth()->user()->isElemental()) {
                $activeChampion = auth()->user()->activeFeatureChampion()->with('feature')->first();
            }
        }

        if (isset($this->search) && $this->search != '') {
            $ideasQuery = $ideas->search($this->search)->paginate(15, ['*'], 'page', 1);
        } else {
            $ideasQuery = $ideas->paginate(15);
        }

        return view('livewire.roadmap.ideas', [
            'ideas' => $ideasQuery,
            'activeChampion' => $activeChampion,
        ]);
    }
}
