<?php

namespace App\Livewire;

use App\Models\Feature;
use App\Models\FeatureCategory;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Roadmap extends Component
{
    #[Url]
    public string $status;

    #[Url]
    public int $idea;
    public Feature $feature;

    public function mount()
    {
        if (isset($this->idea) && !empty($this->idea)) {
            $feat = Feature::approved()->where('id', $this->idea)->first();
            if ($feat) {
                $this->feature = $feat;
            }
        }
    }

    public function inProgress()
    {
        $this->status = 'in-progress';
    }

    public function ideas()
    {
        $this->status = 'ideas';
    }

    public function done()
    {
        $this->status = 'done';
    }


    #[On('open-idea')]
    public function openIdea($idea)
    {
        $this->idea = $idea;
        $this->feature = Feature::visible()->where('id', $this->idea)->first();
        $this->dispatch('open-idea-dialog', url: route('roadmap.feature.show', $this->feature));
    }

    public function open(Feature $feature)
    {
        $this->dispatch('open-idea', idea: $feature->id);
    }

    #[On('idea-closed')]
    public function close()
    {
        $this->idea = 0;
        unset($this->feature);
    }

    public function render()
    {
        $with = ['features', 'next', 'now', 'later', 'done'];
        if (auth()->check()) {
            $with[] = 'next.uservote';
            $with[] = 'now.uservote';
            $with[] = 'later.uservote';
            $with[] = 'done.uservote';
        }
        $categories = FeatureCategory::with($with)->get();
        return view('livewire.roadmap', ['categories' => $categories]);
    }
}
