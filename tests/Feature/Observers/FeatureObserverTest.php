<?php

use App\Enums\FeatureStatus as FeatureStatusEnum;
use App\Jobs\Discord\UpdateFeatureUpvotes;
use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\FeatureStatus;
use Illuminate\Support\Facades\Bus;

it('casts status_id to the feature status enum', function () {
    $feature = observerFeature(FeatureStatusEnum::Approved, 'message');

    expect($feature->status_id)->toBe(FeatureStatusEnum::Approved);
});

it('dispatches a shipped announcement after a transition to Done with a message', function () {
    $feature = observerFeature(FeatureStatusEnum::Approved, 'message');
    Bus::fake();

    $feature->status_id = FeatureStatusEnum::Done;
    $feature->save();

    Bus::assertDispatched(UpdateFeatureUpvotes::class, fn (UpdateFeatureUpvotes $job) => $job->afterCommit);
});

it('does not dispatch for unrelated saves or same status saves', function () {
    $feature = observerFeature(FeatureStatusEnum::Approved, 'message');
    Bus::fake();
    $feature->name = 'Updated name';
    $feature->save();
    $feature->status_id = FeatureStatusEnum::Approved;
    $feature->save();
    Bus::assertNothingDispatched();
});

it('does not dispatch when transitioning to Done without an announcement', function () {
    $feature = observerFeature(FeatureStatusEnum::Approved, null);
    Bus::fake();

    $feature->status_id = FeatureStatusEnum::Done;
    $feature->save();

    Bus::assertNothingDispatched();
});

it('does not dispatch when transitioning to a non-Done status', function () {
    $feature = observerFeature(FeatureStatusEnum::Approved, 'message');
    Bus::fake();

    $feature->status_id = FeatureStatusEnum::Later;
    $feature->save();

    Bus::assertNothingDispatched();
});

function observerFeature(FeatureStatusEnum $status, ?string $messageId): Feature
{
    $category = new FeatureCategory;
    $category->name = uniqid('observer-category');
    $category->save();

    $statusModel = null;
    foreach (FeatureStatusEnum::cases() as $featureStatus) {
        $existingStatus = FeatureStatus::query()->find($featureStatus->value);
        if ($existingStatus) {
            if ($featureStatus === $status) {
                $statusModel = $existingStatus;
            }

            continue;
        }

        $existingStatus = new FeatureStatus;
        $existingStatus->id = $featureStatus->value;
        $existingStatus->name = $featureStatus->name;
        $existingStatus->save();

        if ($featureStatus === $status) {
            $statusModel = $existingStatus;
        }
    }

    return Feature::query()->forceCreate([
        'name' => 'Feature',
        'description' => 'Feature request',
        'category_id' => $category->id,
        'status_id' => $statusModel->id,
        'message_id' => $messageId,
    ]);
}
