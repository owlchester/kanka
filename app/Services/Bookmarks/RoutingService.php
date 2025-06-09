<?php

namespace App\Services\Bookmarks;

use App\Models\Bookmark;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Exception;

class RoutingService
{
    use CampaignAware;

    protected Bookmark $bookmark;

    public function bookmark(Bookmark $bookmark): self
    {
        $this->bookmark = $bookmark;
        return $this;
    }

    /**
     * Get the route the bookmark points to
     */
    public function url(): string
    {
        if ($this->bookmark->dashboard) {
            $dashboard = $this->bookmark->dashboard_id;
            if (Arr::get($this->bookmark->options, 'default_dashboard') === '1') {
                $dashboard = 'default';
            }

            return route('dashboard', [$this->campaign, 'dashboard' => $dashboard, 'bookmark' => $this->bookmark->id]);
        } elseif ($this->bookmark->isRandom()) {
            return route('bookmarks.random', [$this->campaign, $this->bookmark->id]);
        }

        return ! empty($this->bookmark->entity_id) ? $this->getEntityRoute() : $this->getIndexRoute();
    }

    /**
     * Generate a route for an entity's overview or subpage
     */
    protected function getEntityRoute(): string
    {
        $plural = $this->bookmark->target->entityType->pluralCode();
        if (empty($plural)) {
            return '';
        }
        $route = 'entities.show';
        $entity = true;
        if (! empty($this->bookmark->menu)) {
            $menuRoute = $this->bookmark->target->entityType->pluralCode() . '.' . $this->bookmark->menu;
            $entity = false;

            // Inventories use a different url buildup
            $routeOptions = [$this->campaign, $this->bookmark->target->id, 'bookmark' => $this->bookmark->id];
            if ($this->bookmark->menu === 'inventory') {
                return route('entities.inventory', $routeOptions);
            } elseif ($this->bookmark->menu === 'relations') {
                return route('entities.relations.index', $routeOptions);
            } elseif ($this->bookmark->menu === 'abilities') {
                if ($this->bookmark->target->isAbility()) {
                    $routeOptions = [$this->campaign, $this->bookmark->target->entity_id, 'bookmark' => $this->bookmark->id];

                    return route('abilities.abilities', $routeOptions);
                }

                return route('entities.entity_abilities.index', $routeOptions);
            } elseif ($this->bookmark->menu === 'assets') {
                return route('entities.entity_assets.index', $routeOptions);
            } elseif ($this->bookmark->menu === 'reminders') {
                return route('entities.reminders.index', $routeOptions);
            } elseif ($this->bookmark->menu === 'attributes') {
                return route('entities.attributes', $routeOptions);
            }
            if (Route::has($menuRoute)) {
                $route = $menuRoute;
            }
        }

        return route($route, $this->getRouteParams($entity));
    }

    /**
     * Generate the route for a list of entities
     */
    protected function getIndexRoute(): string
    {
        $filters = $this->bookmark->filters . '&_clean=true&_from=bookmark&bookmark=' . $this->bookmark->id;
        if (! empty($this->bookmark->options['is_nested']) && $this->bookmark->options['is_nested'] == '1') {
            $filters .= '&n=1';
        }
        try {
            if ($this->bookmark->entityType->isSpecial()) {
                return route('entities.index', [$this->campaign, $this->bookmark->entityType, $filters]);
            } else {
                return route($this->bookmark->entityType->pluralCode() . '.index', [$this->campaign, $filters]);
            }
        } catch (Exception $e) {
            return '/invalid';
        }
    }

    public function getRouteParams(bool $entity): array
    {
        $parameters = [
            $this->campaign,
            $entity ? $this->bookmark->target : $this->bookmark->target->entity_id,
            'bookmark' => $this->bookmark->id,
        ];

        if (! empty($this->bookmark->menu)) {
            if ($this->bookmark->menu == 'all-members') {
                $parameters['all_members'] = 1;
            }
            if (isset($this->bookmark->options['subview_filter'])) {
                $parameters[] = $this->bookmark->options['subview_filter'];
            }
        }

        return $parameters;
    }
}
