<?php

use App\Models\CampaignDashboardWidget;
use App\Models\Quest;
use App\Models\Tag;

it('syncs widget tags through the API', function () {
    $this->asUser()->withCampaign();
    $tag = Tag::factory()->create(['campaign_id' => 1]);
    $url = '/api/1.0/campaigns/1/campaign_dashboard_widgets';

    $id = $this->postJson($url, ['widget' => 'recent', 'save_tags' => 1, 'tags' => [$tag->id]])
        ->assertCreated()
        ->assertJsonPath('data.tags', [$tag->id])
        ->json('data.id');

    $this->putJson("$url/$id", ['widget' => 'recent', 'save_tags' => 1])
        ->assertOk()
        ->assertJsonPath('data.tags', []);
});

it('POSTS an invalid widget form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/campaign_dashboard_widgets', [])
    ->assertStatus(422);

it('POSTS a new widget')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->postJson('/api/1.0/campaigns/1/campaign_dashboard_widgets', [
        'widget' => 'header',
    ])
    ->assertStatus(201);

it('GETS all dashboard widgets')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->get('/api/1.0/campaigns/1/campaign_dashboard_widgets')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'widget',
            ],
        ],
    ]);

it('GETS a specific dashboard widget')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->get('/api/1.0/campaigns/1/campaign_dashboard_widgets/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'widget',
        ],
    ]);

it('DELETES a dashboard widget')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->delete('/api/1.0/campaigns/1/campaign_dashboard_widgets/1')
    ->assertStatus(204);

it('DELETES an invalid user role')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->delete('/api/1.0/campaigns/1/campaign_dashboard_widgets/100')
    ->assertStatus(404);

it('UPDATES a valid dashboard widget')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->putJson('/api/1.0/campaigns/1/campaign_dashboard_widgets/1', ['position' => 2, 'widget' => 'header'])
    ->assertStatus(200)
    ->assertJsonFragment(['position' => 2]);

it('filters dashboard quest widgets by multiple statuses', function () {
    $this->asUser()->withCampaign();

    $quests = collect([9, 10, 11])->map(function (int $statusId) {
        $quest = Quest::factory()->create(['campaign_id' => 1]);
        $quest->entity->update(['status_id' => $statusId]);

        return $quest;
    });

    $widget = CampaignDashboardWidget::factory()->create([
        'campaign_id' => 1,
        'widget' => 'recent',
        'entity_type_id' => config('entities.ids.quest'),
        'config' => ['filters' => 'status_id[]=9&status_id[]=10'],
    ]);

    expect($widget->filterOptions()['status_id'])->toBe(['9', '10']);
    expect($widget->entities()->getCollection()->pluck('id')->sort()->values()->all())
        ->toBe($quests->take(2)->map(fn (Quest $quest) => $quest->entity->id)->sort()->values()->all());
});
