<?php

namespace App\View\Components\Widgets\Previews;

use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Entity;
use App\Models\Family;
use App\Models\Organisation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Body extends Component
{
    public Campaign $campaign;

    public CampaignDashboardWidget $widget;

    public Entity $entity;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Campaign $campaign,
        CampaignDashboardWidget $widget,
        Entity $entity,
    ) {
        $this->campaign = $campaign;
        $this->widget = $widget;
        $this->entity = $entity;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.previews.body')->with('members', $this->members());
    }

    protected function members(): Collection
    {
        if (! $this->campaign->boosted() || ! $this->widget->showMembers($this->entity) || $this->widget->conf('full') === '2') {
            return new Collection;
        }

        $child = $this->entity->child;
        $child?->setRelation('entity', $this->entity);
        if ($child instanceof Family) {
            return $child->members()->select('characters.*')->with('entity')
                ->leftJoin('entities as member_entities', function ($join): void {
                    $join->on('member_entities.entity_id', '=', 'characters.id')
                        ->where('member_entities.type_id', config('entities.ids.character'));
                })
                ->orderBy('member_entities.name')->get();
        }
        if ($child instanceof Organisation) {
            return $child->members()->select('organisation_member.*')->with(['character', 'character.entity'])
                ->leftJoin('characters', 'characters.id', '=', 'organisation_member.character_id')
                ->leftJoin('entities as member_entities', function ($join): void {
                    $join->on('member_entities.entity_id', '=', 'characters.id')
                        ->where('member_entities.type_id', config('entities.ids.character'));
                })
                ->orderBy('member_entities.name')->get();
        }

        return new Collection;
    }
}
