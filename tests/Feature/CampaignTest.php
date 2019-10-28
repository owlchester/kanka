<?php

namespace Tests\Feature;

use App\Http\Resources\CampaignCollection;
use App\Models\Campaign;
use App\User;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    /**
     * Create a Campaign
     *
     * @return void
     */
    public function testCreateCampaign()
    {
        $this->registerTestUser(true);

        $campaign = Campaign::create([
            'name' => 'TestCampaign'
        ]);
        /** @var User $user */
        $user = auth()->user();

        $user->welcome_campaign_id = $campaign->id;
        $user->save();
        self::assertEquals($campaign->id, $user->welcome_campaign_id);

        /** @var CampaignCollection $campaignCollection */
        $campaignCollection = Campaign::where('name', 'TestCampaign')->get();
        self::assertCount(1, $campaignCollection);
    }

    /**
     * Create a Campaign
     *
     * @return void
     */
    public function testCreateCampaignFrontend()
    {
        $user = $this->createDefaultUser();

        // yes, endpoint for creating a campaing is start @todo should be changed
        $response = $this->actingAs($user)->post(route('start'), [
            'name' => 'TestCampaign'
        ]);

        self::assertEmpty(session('errors'));

        $response->assertStatus(302);
        /** @var CampaignCollection $campaignCollection */
        $campaignCollection = Campaign::where('name', 'TestCampaign')->get();
        self::assertCount(1, $campaignCollection);
    }
}
