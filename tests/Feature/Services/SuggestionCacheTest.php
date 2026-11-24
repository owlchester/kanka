<?php

use App\Facades\CampaignLocalization;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityType;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Services\Caches\SuggestionCache;

it('isolates suggestions by campaign without global campaign priming', function () {
    $this->asUser()->withCampaign();
    $campaign2 = Campaign::factory()->create(['slug' => 'second-campaign']);

    $character1 = Character::factory()->create(['campaign_id' => 1, 'sex' => 'Female', 'pronouns' => 'she/her']);
    $character2 = Character::factory()->create(['campaign_id' => $campaign2->id, 'sex' => 'Non-binary', 'pronouns' => 'they/them']);

    $character1->entity->update(['type' => 'NPC']);
    $character2->entity->update(['type' => 'Hero']);

    CampaignLocalization::clearCampaign();

    $cache = app(SuggestionCache::class);
    $characterType = EntityType::findOrFail(config('entities.ids.character'));

    expect($cache->characterGenders(1))->toBe(['Female'])
        ->and($cache->characterGenders($campaign2))->toBe(['Non-binary'])
        ->and($cache->characterPronouns(1))->toBe(['she/her'])
        ->and($cache->characterPronouns($campaign2))->toBe(['they/them'])
        ->and($cache->entityTypes(1, $characterType))->toBe(['NPC'])
        ->and($cache->entityTypes($campaign2, $characterType))->toBe(['Hero']);
});

it('invalidates quest role suggestions on save and scopes them per campaign', function () {
    $this->asUser()->withCampaign();
    $campaign2 = Campaign::factory()->create(['slug' => 'quest-campaign-2']);

    $quest1 = Quest::factory()->create(['campaign_id' => 1]);
    $quest2 = Quest::factory()->create(['campaign_id' => $campaign2->id]);

    $cache = app(SuggestionCache::class);

    // Prime the cache while empty
    expect($cache->questRoles(1))->toBe([]);

    // Creating a quest element in campaign 1 invalidates campaign 1's cache (fixing the old '2' key mismatch)
    QuestElement::create([
        'quest_id' => $quest1->id,
        'name' => 'Sponsor',
        'role' => 'Patron',
    ]);

    QuestElement::create([
        'quest_id' => $quest2->id,
        'name' => 'Rival',
        'role' => 'Antagonist',
    ]);

    CampaignLocalization::clearCampaign();

    expect($cache->questRoles(1))->toBe(['Patron'])
        ->and($cache->questRoles($campaign2))->toBe(['Antagonist']);
});

it('invalidates character and bookmark suggestions automatically via SuggestionObserver', function () {
    $this->asUser()->withCampaign();

    $cache = app(SuggestionCache::class);

    expect($cache->characterGenders(1))->toBe([])
        ->and($cache->bookmarkIcons(1))->toBe([]);

    CampaignLocalization::clearCampaign();

    Character::factory()->create(['campaign_id' => 1, 'sex' => 'Male', 'pronouns' => 'he/him']);
    Bookmark::create([
        'campaign_id' => 1,
        'name' => 'Home',
        'icon' => 'fa-solid fa-star',
        'is_active' => true,
    ]);

    expect($cache->characterGenders(1))->toBe(['Male'])
        ->and($cache->characterPronouns(1))->toBe(['he/him'])
        ->and($cache->bookmarkIcons(1))->toBe(['fa-solid fa-star']);
});
