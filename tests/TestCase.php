<?php

namespace Tests;

use App\Facades\CampaignCache;
use App\Facades\EntityCache;
use App\Facades\Permissions;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Creature;
use App\Facades\CampaignLocalization;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $isPlayer = false;

    protected function setUp(): void
    {
        parent::setUp();
        //putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . 'en');
    }

    public function asUser(): self
    {
        Passport::actingAs(
            \App\User::factory()->create(),
            ['*']
        );
        return $this;
    }

    public function asPlayer(): self
    {
        $user2 =  \App\User::factory()->create();
        Passport::actingAs(
            $user2,
            ['*']
        );

        $this->isPlayer = true;
        CampaignUser::create([
            'campaign_id' => 1,
            'user_id' => $user2->id,
        ]);

        CampaignRoleUser::create([
            'campaign_role_id' => 3,
            'user_id' => $user2->id,
        ]);

        Permissions::reset();

        return $this;
    }

    public function withCampaign(array $extra = []): self
    {
        $campaign = Campaign::factory()->create($extra);
        CampaignLocalization::forceCampaign($campaign);

        EntityCache::campaign($campaign);
        CampaignCache::campaign($campaign);
        UserCache::campaign($campaign);

        return $this;
    }

    public function withCreatures(array $extra = []): self
    {
        Creature::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }
}
