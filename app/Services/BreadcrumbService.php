<?php

namespace App\Services;

use App\Facades\Module;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class BreadcrumbService
{
    use CampaignAware;
    use EntityAware;

    /**
     * @param string $name
     * @return string
     */
    public function index(string $name): string
    {
        // Determine the "mode" for logged-in users who prefer the old table view
        $params = auth()->check() && auth()->user()->entityExplore === '1' ? ['m' => 'table'] : [];
        $params['campaign'] = $this->campaign;

        // If the user activated nested views by default, go back to it.
        $entityIndexRoute = route($name . '.index', $params);
        if ($this->campaign->defaultToNested() || (auth()->check() && auth()->user()->defaultNested)) {
            if (\Illuminate\Support\Facades\Route::has($name . '.tree')) {
                $entityIndexRoute = route($name . '.tree', $params);
            }
        }

        return $entityIndexRoute;
    }

    public function list(): array
    {
        $fallback = __('entities.' . $this->entity->pluralType());
        return [
            'url' => $this->index($this->entity->pluralType()),
            'label' => Module::plural($this->entity->typeId(), $fallback)
        ];
    }

    public function show(): array
    {
        return [
            'url' => route('entities.show', [$this->campaign, $this->entity]),
            'label' => $this->entity->name
        ];
    }
}
