<?php

namespace Tests;

use App\Facades\EntityCache;
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
        // ID 1 will be the admin of the campaign
        \App\User::factory()->create();

        Passport::actingAs(
            \App\User::factory()->create(),
            ['*']
        );

        $this->isPlayer = true;
        return $this;
    }

    public function withCampaign(array $extra = []): self
    {
        $campaign = Campaign::factory()->create($extra);
        CampaignLocalization::forceCampaign($campaign);

        EntityCache::campaign($campaign);

        // If doing a player run, add it to the player role
        if ($this->isPlayer) {
            CampaignUser::create([
                'campaign_id' => 1,
                'user_id' => 2,
            ]);

            CampaignRoleUser::create([
                'campaign_role_id' => 2,
                'user_id' => 2,
            ]);
        }
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
