<?php

namespace App\Livewire\Roadmap;

use App\Models\Feature;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class Ideas extends Component
{
    use WithPagination;

    public int $pageNumber = 1;

    public Collection $ideas;

    public bool $hasMorePages;

    public function mount()
    {
        $this->ideas = new Collection();
        $this->loadIdeas();
    }

    public function loadIdeas()
    {
        $ideas = Feature::approved();
        if (auth()->check()) {
            $ideas->with('uservote');
        }
        $ideas = $ideas->paginate(15, ['*'], 'page', $this->pageNumber);
        $this->pageNumber += 1;
        $this->hasMorePages = $ideas->hasMorePages();
        $this->ideas->push(...$ideas->items());
    }

    public function render()
    {
        return view('livewire.roadmap.ideas');
    }
}
