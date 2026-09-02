<?php

namespace App\View\Components;

use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Renderers\CharacterSheets\Blade;
use App\Renderers\CharacterSheets\Custom;
use App\Renderers\CharacterSheets\Renderer;
use App\Renderers\CharacterSheets\Twig;
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
        $this->renderer = match ($this->plugin->version->engine) {
            'blade' => app()->make(Blade::class),
            'twig' => app()->make(Twig::class),
            default => app()->make(Custom::class),
        };
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
