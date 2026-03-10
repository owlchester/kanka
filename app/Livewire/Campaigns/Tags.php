<?php

namespace App\Livewire\Campaigns;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\Tag;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Tags extends Component
{
    public Campaign $campaign;

    public string $search = '';

    #[Modelable]
    public array $selected = [];

    public array $options = [];

    public bool $open = false;

    public function mount(Campaign $campaign, array $selected = [])
    {
        $this->campaign = $campaign;
        $this->selected = $selected;

        // Ensure campaign context is always set
        $this->bootCampaignContext();
    }

    /**
     * Input focus → open dropdown immediately
     */
    public function show(): void
    {
        $this->open = true;
        $this->loadDefaultTags();
    }

    /**
     * Typing → debounce → search
     */
    public function updatedSearch(): void
    {
        $this->open = true;

        // If empty, revert to default list
        if ($this->search === '') {
            $this->loadDefaultTags();

            return;
        }

        // Do not search until 2+ chars
        if (strlen($this->search) < 2) {
            $this->options = [];

            return;
        }

        $this->bootCampaignContext();

        $this->options = Tag::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->limit(10)
            ->get()
            ->map(fn ($tag) => [
                'id' => $tag->id,
                'label' => $tag->name,
            ])
            ->toArray();
    }

    protected function loadDefaultTags(): void
    {
        $this->bootCampaignContext();

        $this->options = Tag::query()
            ->orderBy('name') // or ->latest(), ->popular()
            ->limit(10)
            ->get()
            ->map(fn ($tag) => [
                'id' => $tag->id,
                'label' => $tag->name,
            ])
            ->toArray();
    }

    protected function bootCampaignContext(): void
    {
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);
        CampaignLocalization::forceCampaign($this->campaign);
    }

    public function select($id, $label): void
    {
        if (! collect($this->selected)->pluck('id')->contains($id)) {
            $this->selected[] = compact('id', 'label');
        }

        $this->search = '';
        $this->open = false;
    }

    public function remove($id): void
    {
        $this->selected = array_values(
            array_filter($this->selected, fn ($item) => $item['id'] !== $id)
        );
    }

    public function render()
    {
        return view('livewire.campaigns.tags');
    }
}
