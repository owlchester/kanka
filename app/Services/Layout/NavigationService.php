<?php

namespace App\Services\Layout;

use App\Facades\Identity;
use App\Facades\MarketplaceCache;
use App\Facades\PostCache;
use App\Facades\UserCache;
use App\Models\AppRelease;
use App\Models\Campaign;
use App\Models\Pledge;
use App\Notifications\Header;
use App\Services\CampaignLocalization;
use App\User;
use Illuminate\Support\Str;

class NavigationService
{
    protected User $user;

    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function data(): array
    {
        return [
            'profile' => $this->profile(),
            'campaigns' => $this->campaigns(),
            'notifications' => $this->notifications(),
            'marketplace' => $this->marketplace(),
            'releases' => $this->releases(),
        ];
    }

    protected function profile(): array
    {
        $data = [
            'name' => $this->user->name,
            'created' => __('users/profile.fields.member_since', ['date' => $this->user->created_at->format('M d, Y')]),
            'is_impersonating' => false,
        ];

        if (Identity::isImpersonating()) {
            $data['is_impersonating'] = true;

            \App\Facades\CampaignLocalization::setCampaign(Identity::getCampaignId());
            $returnUrl = route('identity.back');
            $campaignUrl = 'campaign/' . Identity::getCampaignId();
            $returnUrl = str_replace('campaign/navigation', $campaignUrl, $returnUrl);
            $data['return'] = [
                'url' => $returnUrl,
                'name' => __('campaigns.members.actions.switch-back'),
            ];
            return $data;
        }
        if (!empty($this->user->pledge) && $this->user->subscribed('kanka')) {
            $data['subscription'] = [
                'tier' => $this->user->pledge,
                'created' => __('users/profile.fields.subscriber_since', ['date' => $this->user->subscription('kanka')->created_at->format('M d, Y')]),
                'image' => 'https://kanka-app-assets.s3.amazonaws.com/images/tiers/' . strtolower($this->user->pledge) . '-325.png',
                'boosters' => __('settings/boosters.available', ['amount' => $this->user->availableBoosts()]),
            ];
        } else {
            $data['subscription'] = [
                'tier' => Pledge::KOBOLD,
                'image' => 'https://kanka-app-assets.s3.amazonaws.com/images/tiers/kobold-325.png',
                'call_to_action' => __('Subscriptions start at USD 5.00 per month')
            ];
        }
        $data['subscription']['title'] = __('settings.menu.subscription');

        $data['urls'] = [
            'settings' => ['url' => route('settings.profile'), 'name' => __('header.user.settings')],
            'profile' => ['url' => route('users.profile', $this->user->id), 'name' => __('header.user.your-profile')],
            'help' => ['url' => 'https://docs.kanka.io/en/latest', 'name' => __('crud.actions.help')],
            'logout' => ['url' => route('logout'), 'name' => __('header.user.sign-out')],
            'subscription' => route('settings.subscription'),
        ];
        return $data;
    }

    protected function campaigns(): array
    {
        $data = [
            'member' => [],
            'following' => [],
            'texts' => [
                'campaigns' => __('sidebar.campaign_switcher.created_campaigns'),
            ]
        ];
        if (Identity::isImpersonating()) {
            return $data;
        }

        $campaigns = $this->user->campaigns;
        $member = 0;
        /** @var Campaign $campaign */
        foreach (UserCache::campaigns() as $campaign) {
            $data['member'][] = [
                'name' => $campaign->name,
                'is_boosted' => $campaign->boosted(),
                'image' => $campaign->thumbnail(100, 100),
                'url' => url(app()->getLocale() . '/' . $campaign->getMiddlewareLink()),
            ];
            $member++;
        }

        foreach (UserCache::follows() as $campaign) {
            $data['following'][] = [
                'name' => $campaign->name,
                'is_boosted' => $campaign->boosted(),
                'image' => $campaign->thumbnail(100, 100),
                'url' => url(app()->getLocale() . '/' . $campaign->getMiddlewareLink()),
            ];
        }

        $data['urls'] = [
            'new' => route('start')
        ];
        $data['texts'] = [
            'new' => __('sidebar.campaign_switcher.new_campaign'),
            'campaigns' => __('sidebar.campaign_switcher.created_campaigns'),
            'followed' => __('sidebar.campaign_switcher.public_campaigns'),
            'count' => __('sidebar.campaign_switcher.count', [
                'member' => $member
            ]),
        ];
        return $data;
    }

    protected function notifications(): array
    {
        if (Identity::isImpersonating()) {
            return [];
        }
        $data = [
            'title' => __('settings.menu.notifications'),
            'all' => [
                'url' => route('notifications'),
                'text' => __('header.notifications.read_all')
            ],
            'none' => __('header.notifications.no-unread')
        ];

        $messages = [];
        /** @var Header $not */
        foreach ($this->user->notifications()->unread()->take(5)->get() as $not) {
            $url = '';
            if(\Illuminate\Support\Arr::has($not->data['params'], 'link')) {
                $url = $not->data['params']['link'];
                if (!\Illuminate\Support\Str::startsWith($url, 'http')) {
                    $url = url(app()->getLocale() . '/' . $url);
                }
            }
            $messages[] = [
                'icon' => $not->data['icon'],
                'text' => __('notifications.' . $not->data['key'], $not->data['params']),
                'url' => $url,
                'is_read' => $not->read(),
            ];
        }

        $data['messages'] = $messages;
        return $data;
    }

    protected function marketplace(): array
    {
        if (!config('marketplace.enabled')) {
            return [];
        }
        $counts = MarketplaceCache::counts();
        $data = [
            'themes' => [
                'title' => __('Themes'),
                'url' => config('marketplace.url') . '/themes',
                'number' => number_format($counts[1]),
            ],
            'sheets' => [
                'title' => __('Sheets'),
                'url' => config('marketplace.url') . '/attribute-templates',
                'number' => number_format($counts[2]),
            ],
            'content' => [
                'title' => __('Content'),
                'url' => config('marketplace.url') . '/content-packs',
                'number' => number_format($counts[3]),
            ],
            'title' => __('front.menu.marketplace'),
            'explore' => [
                'url' => config('marketplace.url'),
                'text' => __('maps.actions.explore'),
            ],
        ];

        return $data;
    }

    protected function releases(): array
    {
        if (Identity::isImpersonating()) {
            return [];
        }

        $data = [
            'title' => __('header.news.title'),
            'news' => []
        ];

        $releases = PostCache::latest();
        $unreadReleases = [];
        /** @var AppRelease $release */
        foreach ($releases as $release) {
            if (!$release->alreadyRead()) {
                $unreadReleases[] = [
                    'id' => $release->id,
                    'url' => $release->link,
                    'title' => $release->name,
                    'text' => $release->excerpt,
                    'dismiss' => route('settings.release', $release)
                ];
            }
        }
        $data['releases'] = $unreadReleases;

        return $data;
    }
}
