<?php

namespace App\View\Components\Campaigns;

use App\Facades\Img;
use App\Models\Campaign;
use App\Models\EntityType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModuleBox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        public EntityType $entityType,
        public array $thumbnails
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.campaigns.module-box')
            ->with('enabled', $this->enabled())
            ->with('image', $this->image());
    }

    protected function enabled(): bool
    {
        if ($this->entityType->isStandard()) {
            return $this->campaign->enabled($this->entityType);
        }

        return $this->entityType->isEnabled();
    }

    protected function image(): string
    {
        foreach ($this->thumbnails as $thumbnail) {
            if ($thumbnail['type'] !== $this->entityType->pluralCode()) {
                continue;
            }

            return Img::crop(96, 96)->url($thumbnail['path']);
        }

        return '';
    }
}
