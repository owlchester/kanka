<?php

namespace App\View\Components\Widgets;

use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class FilteredLink extends Component
{
    public Campaign $campaign;

    public CampaignDashboardWidget $widget;

    public ?string $entityString;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Campaign $campaign,
        CampaignDashboardWidget $widget,
        ?string $entityString = null,
    ) {
        $this->campaign = $campaign;
        $this->widget = $widget;
        $this->entityString = $entityString;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.filtered-link')
            ->with('isLink', $this->isLink())
            ->with('title', $this->title())
            ->with('url', $this->url());
    }

    protected function title(): string
    {
        if (! empty($this->widget->conf('text'))) {
            return $this->widget->conf('text');
        }
        $title = '';
        if (! empty($this->entityString)) {
            $title = __($this->entityString) . ' - ';
        }
        $title .= __('dashboards/widgets/recent.name');

        return $title;
    }

    protected function url(): ?string
    {
        if (! $this->isLink()) {
            return null;
        }
        $parameters = [
            'campaign' => $this->campaign,
            'tags' => $this->widget->tags->pluck('id')->toArray(),
        ] + $this->widget->filterOptions();

        return route(Str::plural($this->widget->conf('entity')) . '.index', $parameters);
    }

    protected function isLink(): bool
    {
        return ! empty($this->widget->conf('entity'));
    }
}
