<?php

namespace App\Livewire\Roadmap;

use App\Models\Feature;
use Livewire\Component;
use Livewire\Attributes\Url;
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

    public function render()
    {
        $ideas = Feature::approved();
        if (auth()->check()) {
            $ideas->with('uservote');
        }

        if (isset($this->search) && $this->search != '') {
            $ideasQuery = $ideas->search($this->search)->paginate(15, ['*'], 'page', 1);
        } else {
            $ideasQuery = $ideas->paginate(15);
        }
        return view('livewire.roadmap.ideas', [
            'ideas' => $ideasQuery
        ]);
    }
}
