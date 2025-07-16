<?php

namespace App\View\Components;

use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Renderers\CharacterSheets\Blade;
use App\Renderers\CharacterSheets\Custom;
use App\Renderers\CharacterSheets\Renderer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CharacterSheet extends Component
{
    public Renderer $renderer;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public CampaignPlugin $plugin,
        public Entity $entity,
        public Campaign $campaign
    ) {
        // Let people update their plugins before using the new syntax
        if ($this->plugin->version->updated_at->gt('2021-03-30 17:00:00')) {
            $this->renderer = app()->make(Blade::class);
        } else {
            $this->renderer = app()->make(Custom::class);
        }
        $this->renderer->campaign($campaign)->entity($entity)->plugin($plugin);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.character-sheet');
    }
}
