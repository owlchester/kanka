<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\CampaignDashboardWidget;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignDashboardWidgetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampaignDashboardWidget::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'widget' => 'header',
        ];
    }
}
