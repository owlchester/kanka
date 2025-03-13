<?php

namespace App\Services\Layout;

use App\Facades\Domain;
use App\Facades\Identity;
use App\Facades\Img;
use App\Facades\MarketplaceCache;
use App\Facades\PostCache;
use App\Facades\UserCache;
use App\Models\AppRelease;
use App\Models\Campaign;
use App\Models\Pledge;
use App\Notifications\Header;
use App\Traits\UserAware;

class NavigationService
{
    use UserAware;

    public function data(): array
    {
        return [
            'profile' => $this->profile(),
            'campaigns' => $this->campaigns(),
            'notifications' => $this->notificationsData(),
            'marketplace' => $this->marketplace(),
            'releases' => $this->releasesData(),
            'has_unread' => $this->user->hasUnread(),
            'fontawesome_pro' => !empty(config('fontawesome.kit'))
        ];
    }

    protected function profile(): array
    {
        $data = [
            'name' => $this->user->name,
            'created' => __('users/profile.fields.member_since', ['date' => $this->user->created_at->format('M d, Y')]),
            'is_impersonating' => false,
            'your_profile' => __('header.user.your-profile')
        ];

        if (Identity::isImpersonating()) {
            $data['is_impersonating'] = true;

            // Get the campaign linked to the impersonation
            $campaign = Campaign::findOrFail(Identity::getCampaignId());

            //\App\Facades\CampaignLocalization::setCampaign(Identity::getCampaignId());
            $returnUrl = route('identity.back', $campaign);
            $campaignUrl = 'campaign/' . $campaign->id;
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
                'image' => 'https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/' . mb_strtolower($this->user->pledge) . '-325.png',
                'boosters' => __('settings/boosters.available', [
                    'amount' => $this->user->availableBoosts(),
                    'total' => $this->user->maxBoosts()
                ]),
            ];
        } else {
            $data['subscription'] = [
                'tier' => Pledge::KOBOLD,
                'image' => 'https://th.kanka.io/A6VJUbyTGHLiGhEat30RzpLGBsY=/64x64/smart/src/app/tiers/kobold.png',
                //'call_to_action' => __('Subscriptions start at USD 5.00 per month')
                'call_to_action' => __('settings/boosters.available', [
                    'amount' => $this->user->availableBoosts(),
                    'total' => $this->user->maxBoosts()
                ]),
                'call_to_action_2' => __('header.user.upgrade')
            ];
        }
        $data['subscription']['title'] = __('settings.menu.subscription');
        if (!config('services.stripe.enabled')) {
            unset($data['subscription']);
        }

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

        $member = 0;
        foreach (UserCache::campaigns() as $campaign) {
            $data['member'][] = [
                'name' => $campaign['name'],
                'is_boosted' => $campaign['boosted'],
                'image' => $campaign['image'] ? Img::crop(100, 96)->url($campaign['image']) : null,
                'url' => $campaign['route'],
            ];
            $member++;
        }

        foreach (UserCache::follows() as $campaign) {
            $data['following'][] = [
                'name' => $campaign['name'],
                'is_boosted' => $campaign['boosted'],
                'image' => $campaign['image'] ? Img::crop(100, 96)->url($campaign['image']) : null,
                'url' => $campaign['route'],
            ];
        }

        $data['urls'] = [
            'new' => route('start'),
            'follow' => Domain::toFront('campaigns'),
            'reorder' => route('settings.appearance', ['highlight' => 'campaign-switcher']),
        ];
        $data['texts'] = [
            'new' => __('sidebar.campaign_switcher.new_campaign'),
            'campaigns' => __('sidebar.campaign_switcher.created_campaigns'),
            'followed' => __('sidebar.campaign_switcher.followed_campaigns'),
            'featured' => __('front.campaigns.featured.title'),
            'reorder' => __('sidebar.campaign_switcher.reorder'),
            'count' => __('sidebar.campaign_switcher.count', [
                'member' => $member
            ]),
            'follow' => __('sidebar.campaign_switcher.follow_more')
        ];
        return $data;
    }

    protected function notificationsData(): array
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

        $data['messages'] = $this->notifications();
        return $data;
    }

    protected function notifications(): array
    {
        $notifications = [];
        /** @var Header $not */
        foreach ($this->user->notifications()->unread()->take(5)->get() as $not) {
            $url = '';
            // @phpstan-ignore-next-line
            if (\Illuminate\Support\Arr::has($not->data['params'], 'link')) {
                // @phpstan-ignore-next-line
                $url = $not->data['params']['link'];
                if (!\Illuminate\Support\Str::startsWith($url, 'http')) {
                    $url = url(app()->getLocale() . '/' . $url);
                }
            }
            $notifications[] = [
                'id' => $not->id,
                'icon' => $not->data['icon'],// @phpstan-ignore-line
                'text' => __('notifications.' . $not->data['key'], $not->data['params']),// @phpstan-ignore-line
                'url' => $url,
                'dismiss' => route('notifications.read', $not->id),
                'dismiss_text' => __('header.notifications.dismiss'),
                'is_read' => $not->read(), // @phpstan-ignore-line
            ];
        }
        return $notifications;
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
            'title' => __('footer.plugins'),
            'explore' => [
                'url' => config('marketplace.url'),
                'text' => __('maps.actions.explore'),
            ],
        ];

        return $data;
    }

    protected function releasesData(): array
    {
        if (Identity::isImpersonating()) {
            return [];
        }

        $data = [
            'title' => __('header.news.title'),
            'news' => []
        ];

        $data['releases'] = $this->releases();

        return $data;
    }

    protected function releases(): array
    {
        $releases = PostCache::latest();
        $unreadReleases = [];
        /** @var AppRelease $release */
        foreach ($releases as $release) {
            if ($release->alreadyRead()) {
                continue;
            }
            $unreadReleases[] = [
                'id' => $release->id,
                'url' => $release->link,
                'title' => $release->name,
                'text' => $release->excerpt,
                'dismiss' => route('settings.release', $release->id),
                'dismiss_text' => __('header.notifications.dismiss'),
            ];
        }
        return $unreadReleases;
    }

    public function pull(): array
    {
        if (Identity::isImpersonating()) {
            return [
                'has_alerts' => false,
                /*'releases' => [],
                'notifications' => [],*/
            ];
        }
        return [
            'has_alerts' => $this->user->hasUnread(),
            /*'releases' => $this->releases(),
            'notifications' => $this->notifications(),*/
        ];
    }
}
