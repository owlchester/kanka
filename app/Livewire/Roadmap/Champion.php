<?php

namespace App\Livewire\Roadmap;

use App\Models\Feature;
use App\Services\Roadmap\FeatureChampionService;
use Livewire\Component;

class Champion extends Component
{
    public Feature $feature;

    public int $count = 0;

    public bool $isChampioned = false;

    public ?int $activeFeatureId = null;

    public ?string $activeFeatureName = null;

    public bool $inline = false;

    public function mount(
        Feature $feature,
        ?int $count = null,
        ?bool $isChampioned = null,
        ?int $activeFeatureId = null,
        ?string $activeFeatureName = null,
        bool $inline = false,
    ): void {
        $this->feature = $feature;
        $this->inline = $inline;
        $this->count = $count ?? (int) ($feature->champions_count ?? $feature->champions()->count());

        if ($isChampioned !== null) {
            $this->isChampioned = $isChampioned;
        } elseif (auth()->check()) {
            $this->isChampioned = $feature->relationLoaded('userChampion')
                ? (bool) $feature->userChampion
                : $feature->userChampion()->exists();
        }

        if ($activeFeatureId !== null || $activeFeatureName !== null) {
            $this->activeFeatureId = $activeFeatureId;
            $this->activeFeatureName = $activeFeatureName;
        } elseif (auth()->check() && auth()->user()->isElemental()) {
            $active = auth()->user()->activeFeatureChampion()->with('feature')->first();
            $this->activeFeatureId = $active?->feature_id;
            $this->activeFeatureName = $active?->feature?->name;
        }
    }

    public function toggle(FeatureChampionService $service): void
    {
        if (auth()->guest()) {
            return;
        }

        $user = auth()->user();

        if ($this->isChampioned) {
            if (! $user->can('unchampion', $this->feature)) {
                return;
            }

            $service->user($user)->unchampion($this->feature);
            $this->isChampioned = false;
            $this->count = max(0, $this->count - 1);
            $this->activeFeatureId = null;
            $this->activeFeatureName = null;
        } else {
            if (! $user->can('champion', $this->feature)) {
                return;
            }

            $service->user($user)->champion($this->feature);
            $this->isChampioned = true;
            $this->count++;
            $this->activeFeatureId = $this->feature->id;
            $this->activeFeatureName = $this->feature->name;
        }

        $this->dispatch('feature-champions-updated');
    }

    public function render()
    {
        return view('livewire.roadmap.champion');
    }
}
