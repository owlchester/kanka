<?php

use App\Enums\FeatureStatus;
use App\Jobs\Discord\SendNewFeature;
use App\Jobs\Discord\UpdateFeatureUpvotes;
use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

it('keeps the normal upvote announcement for active features', function () {
    config(['discord.webhooks.features' => 'https://discord.test/webhook']);
    Http::fake();
    Http::preventStrayRequests();
    $feature = makeDiscordFeature(FeatureStatus::Approved, 4);

    (new UpdateFeatureUpvotes($feature->id))->handle();

    Http::assertSent(fn (Request $request) => $request->method() === 'PATCH'
        && $request['content'] === 'A new idea has been approved and can be voted on! :arrow_up_small: 4.'
        && ! isset($request['embeds']));
});

it('marks completed announcements shipped, including on a late upvote update', function () {
    config(['discord.webhooks.features' => 'https://discord.test/webhook']);
    Http::fake();
    Http::preventStrayRequests();
    $feature = makeDiscordFeature(FeatureStatus::Done, 8);

    (new UpdateFeatureUpvotes($feature->id))->handle();

    Http::assertSent(fn (Request $request) => $request['content'] === 'Shipped'
        && $request['embeds'][0]['description'] === '~~Feature request~~');
});

it('does not send an update when its announcement or webhook is missing', function () {
    Http::fake();
    Http::preventStrayRequests();
    $feature = makeDiscordFeature(FeatureStatus::Done, 0, null);
    config(['discord.webhooks.features' => 'https://discord.test/webhook']);
    (new UpdateFeatureUpvotes($feature->id))->handle();
    config(['discord.webhooks.features' => null]);
    $feature->message_id = 'message';
    $feature->saveQuietly();
    (new UpdateFeatureUpvotes($feature->id))->handle();

    Http::assertNothingSent();
});

it('reconciles an announcement created after the feature was marked Done', function () {
    config(['discord.webhooks.features' => 'https://discord.test/webhook']);
    Http::fake(['discord.test/*' => Http::response(['id' => 'created-message'])]);
    Http::preventStrayRequests();
    $feature = makeDiscordFeature(FeatureStatus::Done, 0);
    $feature->created_by = User::factory()->create()->id;
    $feature->saveQuietly();

    (new SendNewFeature($feature->id))->handle();

    expect($feature->fresh()->message_id)->toBe('created-message');
    Http::assertSent(fn (Request $request) => $request->method() === 'PATCH'
        && $request['content'] === 'Shipped');
});

function makeDiscordFeature(FeatureStatus $status, int $upvotes, ?string $messageId = 'message'): Feature
{
    $category = new FeatureCategory;
    $category->name = uniqid('category');
    $category->save();
    $statusModel = App\Models\FeatureStatus::query()->find($status->value);
    if (! $statusModel) {
        $statusModel = new App\Models\FeatureStatus;
        $statusModel->id = $status->value;
        $statusModel->name = $status->name;
        $statusModel->save();
    }

    return Feature::query()->forceCreate([
        'name' => 'Feature',
        'description' => 'Feature request',
        'category_id' => $category->id,
        'status_id' => $statusModel->id,
        'upvote_count' => $upvotes,
        'message_id' => $messageId,
    ]);
}
