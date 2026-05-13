<?php

namespace App\Services\Search;

use App\Traits\CampaignAware;

class AdminPageService
{
    use CampaignAware;

    /**
     * Return all admin pages matching the given query, or all pages if query is empty.
     */
    public function match(string $query): array
    {
        $pages = $this->allPages();

        if (empty($query)) {
            return $pages;
        }

        return array_values(array_filter($pages, function (array $page) use ($query): bool {
            return stripos($page['name'], $query) !== false;
        }));
    }

    protected function allPages(): array
    {
        $campaign = $this->campaign;

        return [
            [
                'name' => __('campaigns.show.actions.edit'),
                'icon' => 'fa-solid fa-cog',
                'url' => route('campaigns.edit', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.members'),
                'icon' => 'fa-solid fa-users',
                'url' => route('campaign_users.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.roles'),
                'icon' => 'fa-solid fa-shield-halved',
                'url' => route('campaign_roles.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.webhooks'),
                'icon' => 'fa-solid fa-webhook',
                'url' => route('webhooks.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns/categories.tab'),
                'icon' => 'fa-solid fa-layer-group',
                'url' => route('entity_types.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.plugins'),
                'icon' => 'fa-solid fa-plug',
                'url' => route('campaign_plugins.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns/recovery.title'),
                'icon' => 'fa-solid fa-rotate-left',
                'url' => route('recovery', $campaign),
                'group' => 'admin',
            ],
        ];
    }
}
