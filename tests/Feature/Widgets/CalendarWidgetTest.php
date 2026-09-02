<?php

use App\Enums\Widget;
use App\Models\Calendar;
use App\Models\CampaignDashboardWidget;

function calendarWidget(): CampaignDashboardWidget
{
    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-2',
        'moons' => json_encode([
            ['id' => 1, 'name' => 'Luna', 'fullmoon' => 10, 'offset' => 0, 'colour' => 'grey'],
        ]),
    ]);

    return CampaignDashboardWidget::create([
        'campaign_id' => 1,
        'entity_id' => $calendar->entity->id,
        'widget' => Widget::Calendar,
    ]);
}

it('renders semantic moon context and preserves the widget html contract', function () {
    $this->asUser()->withCampaign();
    $widget = calendarWidget();

    $this->get('/w/test-campaign/dashboard/widgets/' . $widget->id . '/render')
        ->assertSuccessful()
        ->assertSee('data-id="1"', false)
        ->assertSee('Luna waning gibbous', false)
        ->assertSee('widget-calendar-switch', false);
});

it('prevents read-only users from changing the calendar widget date', function () {
    $this->asUser()->withCampaign();
    $widget = calendarWidget();
    $date = $widget->entity->child->date;

    $this->asPlayer()
        ->post('/w/test-campaign/dashboard/widgets/' . $widget->id . '/add')
        ->assertNotFound();

    expect($widget->entity->child->fresh()->date)->toBe($date);
});
