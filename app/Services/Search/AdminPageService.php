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
            if (stripos($page['name'], $query) !== false) {
                return true;
            }
            foreach ($page['keywords'] ?? [] as $keyword) {
                if (stripos($keyword, $query) !== false) {
                    return true;
                }
            }

            return false;
        }));
    }

    protected function allPages(): array
    {
        $campaign = $this->campaign;

        return [
            [
                'name' => __('campaigns.show.actions.edit'),
                'icon' => 'fa-regular fa-cog',
                'url' => route('campaigns.edit', $campaign),
                'group' => 'admin',
                'keywords' => ['settings', 'config', 'configure', 'setup'],
            ],
            [
                'name' => __('campaigns.show.tabs.members'),
                'icon' => 'fa-regular fa-users',
                'url' => route('campaign_users.index', $campaign),
                'group' => 'admin',
                'keywords' => ['users', 'players', 'invite', 'people'],
            ],
            [
                'name' => __('campaigns.show.tabs.roles'),
                'icon' => 'fa-regular fa-shield-halved',
                'url' => route('campaign_roles.index', $campaign),
                'group' => 'admin',
                'keywords' => ['permissions', 'access', 'rights'],
            ],
            [
                'name' => __('campaigns.show.tabs.webhooks'),
                'icon' => 'fa-regular fa-webhook',
                'url' => route('webhooks.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns/logs.title'),
                'icon' => 'fa-regular fa-history',
                'url' => route('campaign.logs', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns/categories.tab'),
                'icon' => 'fa-regular fa-floppy-disks',
                'url' => route('campaign.modules', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.plugins'),
                'icon' => 'fa-regular fa-puzzle-piece',
                'url' => route('campaign_plugins.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns/recovery.title'),
                'icon' => 'fa-regular fa-trash-restore',
                'url' => route('recovery', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.achievements'),
                'icon' => 'fa-regular fa-trophy',
                'url' => route('campaign.achievements', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.stats'),
                'icon' => 'fa-regular fa-bars',
                'url' => route('campaign.stats', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.gallery'),
                'icon' => 'fa-regular fa-files',
                'url' => route('gallery', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.show.tabs.styles'),
                'icon' => 'fa-regular fa-palette',
                'url' => route('campaign_styles.index', $campaign),
                'group' => 'admin',
                'keywords' => ['css', 'style', 'theme', 'design'],
            ],

            [
                'name' => __('bug-report.title'),
                'icon' => 'fa-regular fa-bug',
                'url' => route('bug-report'),
                'group' => 'admin',
                'keywords' => ['bug', 'report', 'issue', 'problem', 'error', 'broken'],
            ],

            // Documentation and external pages
            [
                'name' => __('footer.documentation'),
                'icon' => 'fa-regular fa-book',
                'url' => 'https://docs.kanka.io',
                'group' => 'docs',
                'keywords' => ['help', 'docs', 'guide', 'manual', 'wiki', 'tutorial'],
            ],
            [
                'name' => __('front.features.api.link'),
                'icon' => 'fa-regular fa-code',
                'url' => __('larecipe.index'),
                'group' => 'docs',
                'keywords' => ['help', 'api', 'developer', 'docs'],
            ],

            // Socials
            [
                'name' => __('Discord'),
                'icon' => 'fa-brands fa-discord',
                'url' => 'https://kanka.io/go/discord',
                'group' => 'socials',
            ],
            [
                'name' => __('Youtube'),
                'icon' => 'fa-brands fa-youtube',
                'url' => 'https://kanka.io/go/youtube',
                'group' => 'socials',
                'keywords' => ['tutorial', 'video'],
            ],
            [
                'name' => __('Github'),
                'icon' => 'fa-brands fa-github',
                'url' => 'https://kanka.io/go/github',
                'group' => 'socials',
                'keywords' => ['code', 'source'],
            ],
        ];
    }
}
