# Entity Mentions Polymorphic Refactor Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace `entity_mentions`'s five owner columns (`entity_id`, `post_id`, `timeline_element_id`, `quest_element_id`, `campaign_id`) with a `mentionable_type`/`mentionable_id` polymorphic pair, while keeping `entity_id` as a dedicated denormalized rollup column, so a future mentionable type (e.g. `MapMarker`) needs zero schema changes.

**Architecture:** One migration backfills the new morph columns from the five legacy columns and drops the four owner-discriminator columns (keeping `entity_id` as the rollup). `EntityMention` gains a `mentionable()` morphTo plus backward-compatible virtual attribute accessors so every existing call site (`isPost()`, `$model->quest_element_id`, `$model->post`, etc.) keeps working unchanged. `Post`/`TimelineElement`/`QuestElement`/`Campaign`'s hand-rolled `mentions()` relations become `morphMany`. `EntityMappingService::createNewMention()` collapses its 5-branch column-setting into `mentionable()->associate()` + a single `entity_id` rollup resolver, with all existing self-mention guards preserved verbatim.

**Tech Stack:** Laravel 11, PHP 8.4, Eloquent polymorphic relations, Pest 3.

## Global Constraints

- Preserve every existing public method name/signature that other files call: `isPost()`, `isEntity()`, `isTimelineElement()`, `isQuestElement()`, `isCampaign()`, `post()`, `timelineElement()`, `questElement()`, `campaign()`, `entity()`, `target()`, `scopeOnEntity/OnPost/OnTimelineElement/OnQuestElement/OnCampaign`, `scopeFilterValid`, `scopeDatagridElements`.
- `isEntity()` must stay implemented as `! empty($this->entity_id)` **verbatim, unchanged** — do not reimplement it via `mentionable_type`. Two real call sites (`App\Http\Controllers\Entities\Apis\DocumentController::mentions()` and `resources/views/dashboard/widgets/_preview.blade.php`) call it on rows from `Entity::mentions()` (the `entity_id` rollup relation), where `entity_id` is non-null for every row regardless of true owner type — changing this would silently flip behavior for Post/Timeline/Quest-owned rows in that context.
- Preserve the exact self-mention guard semantics in `EntityMappingService::createNewMention()`: Post compares `$this->model->entity_id == $target`, TimelineElement compares `$this->model->timeline_id == $target`, QuestElement compares `$this->model->quest_id == $target`, the Entity (else) branch compares `$this->model->id == $target`, and Campaign has no guard at all.
- No chunked/batched backfill — no precedent in this codebase (`grep -rln "chunkById|chunk(" database/migrations/` is empty) and this is a same-table column consolidation, not a cross-table copy.
- Curly braces on all control structures, explicit return types and param type hints, PHPDoc blocks over inline comments (per project PHP conventions).
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP file change, before committing.
- Tests via `vendor/bin/sail artisan test --compact --filter=<Name>`.

---

### Task 1: Migration — `entity_mentions` polymorphic columns + backfill

**Files:**
- Create: `database/migrations/2026_07_14_120000_convert_entity_mentions_to_polymorphic.php`
- Test: `tests/Feature/Migrations/EntityMentionsPolymorphicMigrationTest.php`

**Interfaces:**
- Produces: `entity_mentions.mentionable_type` (string, nullable), `entity_mentions.mentionable_id` (unsignedBigInteger, nullable), index on `(mentionable_type, mentionable_id)`. `entity_mentions.entity_id` stays (nullable, FK dropped). `entity_mentions.post_id`, `timeline_element_id`, `quest_element_id`, `campaign_id` are dropped.

- [ ] **Step 1: Write the failing test**

```php
<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('has the polymorphic mentionable columns and drops the legacy owner columns', function () {
    expect(Schema::hasColumn('entity_mentions', 'mentionable_type'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'mentionable_id'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'entity_id'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'target_id'))->toBeTrue();
    expect(Schema::hasColumn('entity_mentions', 'post_id'))->toBeFalse();
    expect(Schema::hasColumn('entity_mentions', 'timeline_element_id'))->toBeFalse();
    expect(Schema::hasColumn('entity_mentions', 'quest_element_id'))->toBeFalse();
    expect(Schema::hasColumn('entity_mentions', 'campaign_id'))->toBeFalse();
});

it('backfills mentionable_type/mentionable_id from the legacy owner columns on migrate', function () {
    // Roll back just this migration, re-insert rows shaped like the legacy schema,
    // then re-run the migration and assert the backfill mapped each owner type correctly.
    $this->artisan('migrate:rollback', ['--step' => 1])->run();

    DB::table('entities')->insert([
        ['id' => 1, 'campaign_id' => 1, 'type_id' => 1, 'name' => 'Target', 'is_private' => 0, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'campaign_id' => 1, 'type_id' => 1, 'name' => 'Entity Owner', 'is_private' => 0, 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'campaign_id' => 1, 'type_id' => 1, 'name' => 'Post Owner Parent', 'is_private' => 0, 'created_at' => now(), 'updated_at' => now()],
    ]);
    DB::table('campaigns')->insert([
        'id' => 1, 'name' => 'Test', 'created_by' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('posts')->insert([
        'id' => 1, 'entity_id' => 3, 'name' => 'A post', 'entry' => '', 'position' => 1, 'created_at' => now(), 'updated_at' => now(),
    ]);

    DB::table('entity_mentions')->insert([
        // Entity-owned: entity_id set, nothing else.
        ['entity_id' => 2, 'target_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        // Post-owned: post_id set + entity_id rollup to the post's parent entity.
        ['entity_id' => 3, 'post_id' => 1, 'target_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        // Campaign-owned: only campaign_id set.
        ['campaign_id' => 1, 'target_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ]);

    $this->artisan('migrate')->run();

    $rows = DB::table('entity_mentions')->orderBy('id')->get();

    expect($rows[0]->mentionable_type)->toBe('App\Models\Entity');
    expect($rows[0]->mentionable_id)->toBe(2);
    expect($rows[0]->entity_id)->toBe(2);

    expect($rows[1]->mentionable_type)->toBe('App\Models\Post');
    expect($rows[1]->mentionable_id)->toBe(1);
    expect($rows[1]->entity_id)->toBe(3);

    expect($rows[2]->mentionable_type)->toBe('App\Models\Campaign');
    expect($rows[2]->mentionable_id)->toBe(1);
    expect($rows[2]->entity_id)->toBeNull();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionsPolymorphicMigrationTest`
Expected: FAIL — `mentionable_type`/`mentionable_id` columns don't exist yet (migration file doesn't exist).

- [ ] **Step 3: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->string('mentionable_type')->nullable()->after('id');
            $table->unsignedBigInteger('mentionable_id')->nullable()->after('mentionable_type');
        });

        DB::table('entity_mentions')
            ->whereNotNull('entity_id')
            ->whereNull('post_id')
            ->whereNull('timeline_element_id')
            ->whereNull('quest_element_id')
            ->update([
                'mentionable_type' => 'App\Models\Entity',
                'mentionable_id' => DB::raw('entity_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('post_id')
            ->update([
                'mentionable_type' => 'App\Models\Post',
                'mentionable_id' => DB::raw('post_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('timeline_element_id')
            ->update([
                'mentionable_type' => 'App\Models\TimelineElement',
                'mentionable_id' => DB::raw('timeline_element_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('quest_element_id')
            ->update([
                'mentionable_type' => 'App\Models\QuestElement',
                'mentionable_id' => DB::raw('quest_element_id'),
            ]);

        DB::table('entity_mentions')
            ->whereNotNull('campaign_id')
            ->update([
                'mentionable_type' => 'App\Models\Campaign',
                'mentionable_id' => DB::raw('campaign_id'),
            ]);

        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->index(['mentionable_type', 'mentionable_id']);

            $table->dropForeign(['entity_id']);
            $table->dropForeign(['post_id']);
            $table->dropForeign(['timeline_element_id']);
            $table->dropForeign(['quest_element_id']);
            $table->dropForeign(['campaign_id']);

            $table->dropColumn(['post_id', 'timeline_element_id', 'quest_element_id', 'campaign_id']);
        });
    }

    public function down(): void
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->integer('post_id')->unsigned()->nullable();
            $table->unsignedBigInteger('timeline_element_id')->nullable();
            $table->unsignedBigInteger('quest_element_id')->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
        });

        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\Post')
            ->update(['post_id' => DB::raw('mentionable_id')]);
        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\TimelineElement')
            ->update(['timeline_element_id' => DB::raw('mentionable_id')]);
        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\QuestElement')
            ->update(['quest_element_id' => DB::raw('mentionable_id')]);
        DB::table('entity_mentions')->where('mentionable_type', 'App\Models\Campaign')
            ->update(['campaign_id' => DB::raw('mentionable_id')]);

        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('timeline_element_id')->references('id')->on('timeline_elements')->onDelete('cascade');
            $table->foreign('quest_element_id')->references('id')->on('quest_elements')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->dropIndex(['mentionable_type', 'mentionable_id']);
            $table->dropColumn(['mentionable_type', 'mentionable_id']);
        });
    }
};
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionsPolymorphicMigrationTest`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add database/migrations/2026_07_14_120000_convert_entity_mentions_to_polymorphic.php tests/Feature/Migrations/EntityMentionsPolymorphicMigrationTest.php
git commit -m "feat: add polymorphic mentionable columns to entity_mentions"
```

---

### Task 2: `EntityMention` model — `mentionable()` + backward-compatible accessors

**Files:**
- Modify: `app/Models/EntityMention.php`
- Test: `tests/Feature/Models/EntityMentionTest.php`

**Interfaces:**
- Consumes: `entity_mentions.mentionable_type`/`mentionable_id` (Task 1).
- Produces: `EntityMention::mentionable(): MorphTo`; virtual attributes `post_id`, `timeline_element_id`, `quest_element_id`, `campaign_id` (readable via `$model->post_id` etc., derived from `mentionable_type`/`mentionable_id`); `isPost()/isTimelineElement()/isQuestElement()/isCampaign()` derived from `mentionable_type`; `isEntity()` unchanged (`! empty($this->entity_id)`); `scopeOnEntity/OnPost/OnTimelineElement/OnQuestElement/OnCampaign` derived from `mentionable_type`; `scopeFilterValid` via `whereHasMorph`; `scopeDatagridElements` no longer orders by the dropped `campaign_id` column.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Campaign;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;

test('exposes virtual owner-id attributes derived from mentionable_type/mentionable_id', function () {
    $this->asUser()->withCampaign();

    $postMention = EntityMention::create([
        'mentionable_type' => Post::class,
        'mentionable_id' => 42,
        'entity_id' => 7,
        'target_id' => 1,
    ]);
    expect($postMention->post_id)->toBe(42);
    expect($postMention->timeline_element_id)->toBeNull();
    expect($postMention->quest_element_id)->toBeNull();
    expect($postMention->campaign_id)->toBeNull();
    expect($postMention->isPost())->toBeTrue();
    expect($postMention->isTimelineElement())->toBeFalse();
    expect($postMention->isQuestElement())->toBeFalse();
    expect($postMention->isCampaign())->toBeFalse();

    $timelineMention = EntityMention::create([
        'mentionable_type' => TimelineElement::class,
        'mentionable_id' => 5,
        'entity_id' => 7,
        'target_id' => 1,
    ]);
    expect($timelineMention->timeline_element_id)->toBe(5);
    expect($timelineMention->isTimelineElement())->toBeTrue();

    $questMention = EntityMention::create([
        'mentionable_type' => QuestElement::class,
        'mentionable_id' => 9,
        'entity_id' => 7,
        'target_id' => 1,
    ]);
    expect($questMention->quest_element_id)->toBe(9);
    expect($questMention->isQuestElement())->toBeTrue();

    $campaignMention = EntityMention::create([
        'mentionable_type' => Campaign::class,
        'mentionable_id' => 1,
        'entity_id' => null,
        'target_id' => 1,
    ]);
    expect($campaignMention->campaign_id)->toBe(1);
    expect($campaignMention->isCampaign())->toBeTrue();
    // isEntity() checks entity_id (unchanged, rollup semantics), not mentionable_type.
    expect($campaignMention->isEntity())->toBeFalse();
});

test('scopeOnX filters by mentionable_type', function () {
    $this->asUser()->withCampaign();

    EntityMention::create(['mentionable_type' => Post::class, 'mentionable_id' => 1, 'entity_id' => 7, 'target_id' => 1]);
    EntityMention::create(['mentionable_type' => Campaign::class, 'mentionable_id' => 1, 'target_id' => 1]);

    expect(EntityMention::onPost()->count())->toBe(1);
    expect(EntityMention::onCampaign()->count())->toBe(1);
    expect(EntityMention::onEntity()->count())->toBe(0);
});

test('scopeDatagridElements no longer references the dropped campaign_id column', function () {
    $this->asUser()->withCampaign();

    EntityMention::create(['mentionable_type' => Campaign::class, 'mentionable_id' => 1, 'target_id' => 1]);

    // This would throw a SQL error ("column campaign_id does not exist") if the
    // orderBy still referenced the dropped column.
    expect(fn () => EntityMention::datagridElements(['k' => 'name', 'o' => 'asc'])->get())->not->toThrow(Exception::class);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionTest`
Expected: FAIL — `mentionable_type` isn't `$fillable`, `mentionable()` doesn't exist, `post_id`/etc. accessors don't exist, `scopeDatagridElements` still calls `orderBy('campaign_id')` (SQL error since Task 1 dropped it).

- [ ] **Step 3: Rewrite the model**

```php
<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;

/**
 * Class EntityMention
 *
 * @property ?string $mentionable_type
 * @property ?int $mentionable_id
 * @property ?int $entity_id Denormalized parent-entity rollup; set for Entity/Post/TimelineElement/QuestElement owners, null for Campaign owners.
 * @property int $target_id
 * @property Entity $entity
 * @property Post|null $post
 * @property QuestElement|null $questElement
 * @property TimelineElement|null $timelineElement
 * @property ?Entity $target
 * @property Campaign|null $campaign
 * @property-read int|null $post_id Virtual, derived from mentionable_type/mentionable_id.
 * @property-read int|null $timeline_element_id Virtual, derived from mentionable_type/mentionable_id.
 * @property-read int|null $quest_element_id Virtual, derived from mentionable_type/mentionable_id.
 * @property-read int|null $campaign_id Virtual, derived from mentionable_type/mentionable_id.
 *
 * @method static self|Builder filterValid()
 */
class EntityMention extends Model
{
    use SortableTrait;

    public $fillable = [
        'mentionable_type',
        'mentionable_id',
        'entity_id',
        'target_id',
    ];

    protected array $sortable = [
        'name',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function mentionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * Only meaningful when isPost() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Post', 'mentionable_id', 'id');
    }

    /**
     * Only meaningful when isTimelineElement() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<TimelineElement, $this>
     */
    public function timelineElement(): BelongsTo
    {
        return $this->belongsTo('App\Models\TimelineElement', 'mentionable_id', 'id');
    }

    /**
     * Only meaningful when isQuestElement() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<QuestElement, $this>
     */
    public function questElement(): BelongsTo
    {
        return $this->belongsTo('App\Models\QuestElement', 'mentionable_id', 'id');
    }

    /**
     * Only meaningful when isCampaign() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'mentionable_id', 'id');
    }

    public function getPostIdAttribute(): ?int
    {
        return $this->mentionable_type === Post::class ? $this->mentionable_id : null;
    }

    public function getTimelineElementIdAttribute(): ?int
    {
        return $this->mentionable_type === TimelineElement::class ? $this->mentionable_id : null;
    }

    public function getQuestElementIdAttribute(): ?int
    {
        return $this->mentionable_type === QuestElement::class ? $this->mentionable_id : null;
    }

    public function getCampaignIdAttribute(): ?int
    {
        return $this->mentionable_type === Campaign::class ? $this->mentionable_id : null;
    }

    /**
     * Determine if the mention goes to a post
     */
    public function isPost(): bool
    {
        return $this->mentionable_type === Post::class;
    }

    /**
     * Determine if the mention goes to an entity.
     *
     * NOTE: intentionally checks entity_id (the rollup column), not mentionable_type.
     * entity_id is also populated for Post/TimelineElement/QuestElement-owned mentions
     * (it's their parent-entity rollup), so this is true for every row returned by
     * Entity::mentions() regardless of true owner — matching pre-refactor behavior
     * relied on by DocumentController::mentions() and the dashboard widget preview.
     */
    public function isEntity(): bool
    {
        return ! empty($this->entity_id);
    }

    /**
     * Determine if the mention goes to a timeline element
     */
    public function isTimelineElement(): bool
    {
        return $this->mentionable_type === TimelineElement::class;
    }

    /**
     * Determine if the mention goes to a quest element
     */
    public function isQuestElement(): bool
    {
        return $this->mentionable_type === QuestElement::class;
    }

    /**
     * Determine if the mention goes to a campaign
     */
    public function isCampaign(): bool
    {
        return $this->mentionable_type === Campaign::class;
    }

    /**
     * Build the query that will loop on the various mentions to get the total count.
     * The AclTrait on entities and posts makes sure only visible things get added to the query.
     */
    public function scopeFilterValid(Builder $query): Builder
    {
        return $query->whereHasMorph(
            'mentionable',
            [Entity::class, Post::class, TimelineElement::class, QuestElement::class, Campaign::class],
            function (Builder $query, string $type) {
                if ($type === Post::class) {
                    $query->has('entity');
                } elseif ($type === TimelineElement::class) {
                    $query->has('timeline.entity');
                } elseif ($type === QuestElement::class) {
                    $query->has('quest.entity');
                }
            }
        );
    }

    public function scopeOnEntity(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', Entity::class);
    }

    public function scopeOnPost(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', Post::class);
    }

    public function scopeOnTimelineElement(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', TimelineElement::class);
    }

    public function scopeOnQuestElement(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', QuestElement::class);
    }

    public function scopeOnCampaign(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', Campaign::class);
    }

    public function scopeDatagridElements(Builder $query, array $options): Builder
    {
        $column = Arr::get($options, 'k', 'name');
        $order = Arr::get($options, 'o', 'asc');
        $query->select('entity_mentions.*')
            ->leftJoin('entities as e', 'e.id', 'entity_mentions.entity_id');

        if ($column == 'name') {
            $query->orderByRaw('CASE WHEN e.name IS NULL THEN 1 ELSE 0 END');
            $query->orderBy('e.name', $order);
        } elseif ($column == 'type') {
            $query->orderByRaw('CASE WHEN e.type_id IS NULL THEN 1 ELSE 0 END');
            $query->orderBy('e.type_id', $order);
        }

        return $query
            ->orderBy('entity_mentions.id');
    }

    /**
     * Determine if the mention is linked to an entity.
     * In theory, this is true for everything except a campaign mention, but in practice it's more complicated.
     */
    public function hasEntity(): bool
    {
        return ! empty($this->entity_id) && ! empty($this->entity);
    }

    public function exportFields(): array
    {
        return [
            'entity_id',
            'campaign_id',
            'post_id',
            'timeline_element_id',
            'quest_element_id',
            'target_id',
        ];
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionTest`
Expected: PASS

- [ ] **Step 5: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 6: Commit**

```bash
git add app/Models/EntityMention.php tests/Feature/Models/EntityMentionTest.php
git commit -m "refactor: rebuild EntityMention around mentionable_type/mentionable_id"
```

---

### Task 3: Owner-side `mentions()` relations → `morphMany`

**Files:**
- Modify: `app/Models/Post.php:136` (`mentions()`)
- Modify: `app/Models/TimelineElement.php:175` (`mentions()`)
- Modify: `app/Models/QuestElement.php:116` (`mentions()`)
- Modify: `app/Models/Relations/CampaignRelations.php:344` (`mentions()`)
- Test: `tests/Feature/Models/EntityMentionOwnerRelationsTest.php`

**Interfaces:**
- Consumes: `EntityMention::mentionable()` (Task 2).
- Produces: `Post::mentions()`, `TimelineElement::mentions()`, `QuestElement::mentions()`, `Campaign::mentions()` — each a `MorphMany<EntityMention, $this>` returning only `EntityMention` rows owned by that specific model instance.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Campaign;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\Quest;
use App\Models\TimelineElement;
use App\Models\Timeline;

test('Post::mentions() returns only this post\'s owned mentions', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $post = Post::factory()->create(['entity_id' => 1]);
    $otherPost = Post::factory()->create(['entity_id' => 1]);

    EntityMention::create(['mentionable_type' => Post::class, 'mentionable_id' => $post->id, 'entity_id' => 1, 'target_id' => 2]);
    EntityMention::create(['mentionable_type' => Post::class, 'mentionable_id' => $otherPost->id, 'entity_id' => 1, 'target_id' => 2]);

    expect($post->mentions()->count())->toBe(1);
    expect($post->mentions()->first()->mentionable_id)->toBe($post->id);
});

test('TimelineElement::mentions() returns only this element\'s owned mentions', function () {
    $this->asUser()->withCampaign();
    $timeline = Timeline::factory()->create(['campaign_id' => 1]);
    $element = TimelineElement::factory()->create(['timeline_id' => $timeline->id]);

    EntityMention::create(['mentionable_type' => TimelineElement::class, 'mentionable_id' => $element->id, 'entity_id' => $timeline->entity->id, 'target_id' => 1]);

    expect($element->mentions()->count())->toBe(1);
});

test('QuestElement::mentions() returns only this element\'s owned mentions', function () {
    $this->asUser()->withCampaign();
    $quest = Quest::factory()->create(['campaign_id' => 1]);
    $element = QuestElement::factory()->create(['quest_id' => $quest->id]);

    EntityMention::create(['mentionable_type' => QuestElement::class, 'mentionable_id' => $element->id, 'entity_id' => $quest->entity->id, 'target_id' => 1]);

    expect($element->mentions()->count())->toBe(1);
});

test('Campaign::mentions() returns only this campaign\'s owned mentions', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::find(1);

    EntityMention::create(['mentionable_type' => Campaign::class, 'mentionable_id' => $campaign->id, 'target_id' => 1]);

    expect($campaign->mentions()->count())->toBe(1);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionOwnerRelationsTest`
Expected: FAIL — the hand-rolled `hasMany` relations are still keyed on the dropped `post_id`/`timeline_element_id`/`quest_element_id`/`campaign_id` columns, so `mentions()` throws a SQL error on those columns.

- [ ] **Step 3: Update the four relations**

`app/Models/Post.php` (replace the existing `mentions()` at line 136):

```php
    /**
     * List of entities that mention this entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<EntityMention, $this>
     */
    public function mentions(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(EntityMention::class, 'mentionable');
    }
```

`app/Models/TimelineElement.php` (replace the existing `mentions()` at line 175), same shape as above.

`app/Models/QuestElement.php` (replace the existing `mentions()` at line 116), same shape as above.

`app/Models/Relations/CampaignRelations.php` (replace the existing `mentions()` at line 344), same shape as above.

For each file, add `use Illuminate\Database\Eloquent\Relations\MorphMany;` to the imports and use the plain `MorphMany` type hint instead of the fully-qualified name inline (matching each file's existing import style — check the file's current `use` block and follow it).

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionOwnerRelationsTest`
Expected: PASS

- [ ] **Step 5: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 6: Commit**

```bash
git add app/Models/Post.php app/Models/TimelineElement.php app/Models/QuestElement.php app/Models/Relations/CampaignRelations.php tests/Feature/Models/EntityMentionOwnerRelationsTest.php
git commit -m "refactor: Post/TimelineElement/QuestElement/Campaign mentions() as morphMany"
```

---

### Task 4: `EntityMappingService::createNewMention()` + `resolveEntityId()`

**Files:**
- Modify: `app/Services/EntityMappingService.php:71-114` (`createNewMention()`)
- Test: `tests/Feature/Services/EntityMappingServiceTest.php`

**Interfaces:**
- Consumes: `EntityMention::mentionable()` (Task 2), `Post/TimelineElement/QuestElement/Campaign::mentions()` (Task 3).
- Produces: `EntityMappingService::createNewMention(int $target): void` (unchanged signature/visibility), new `EntityMappingService::resolveEntityId(): ?int` (protected).

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Timeline;
use App\Models\TimelineElement;

test('mentioning a character in an entity\'s own entry creates an Entity-owned mention', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    $mention = EntityMention::where('target_id', $target->id)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_type)->toBe(\App\Models\Entity::class);
    expect($mention->mentionable_id)->toBe($author->id);
    expect($mention->entity_id)->toBe($author->id);
});

test('mentioning a character in a post creates a Post-owned mention with the post\'s parent-entity rollup', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $parent = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $post = Post::factory()->create([
        'entity_id' => $parent->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', Post::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($post->id);
    expect($mention->entity_id)->toBe($parent->id);
});

test('a post mentioning its own parent entity is skipped (self-mention guard)', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $parent = Character::find(1)->entity;

    Post::factory()->create([
        'entity_id' => $parent->id,
        'entry' => '[character:' . $parent->id . ']',
    ]);

    expect(EntityMention::where('target_id', $parent->id)->count())->toBe(0);
});

test('mentioning a character in a timeline element creates a TimelineElement-owned mention rolled up to the timeline\'s entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $timeline = Timeline::factory()->create(['campaign_id' => 1]);

    $element = TimelineElement::factory()->create([
        'timeline_id' => $timeline->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', TimelineElement::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($element->id);
    expect($mention->entity_id)->toBe($timeline->entity->id);
});

test('mentioning a character in a quest element creates a QuestElement-owned mention rolled up to the quest\'s entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $quest = Quest::factory()->create(['campaign_id' => 1]);

    $element = QuestElement::factory()->create([
        'quest_id' => $quest->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', QuestElement::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($element->id);
    expect($mention->entity_id)->toBe($quest->entity->id);
});

test('mentioning a character in the campaign entry creates a Campaign-owned mention with no entity_id rollup', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $campaign = Campaign::find(1);

    $campaign->entry = '[character:' . $target->id . ']';
    $campaign->save();

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', Campaign::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($campaign->id);
    expect($mention->entity_id)->toBeNull();
});

test('removing a mention from the entry deletes the corresponding EntityMention row', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(1);

    $author->entry = 'no more mentions';
    $author->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(0);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMappingServiceTest`
Expected: FAIL — `createNewMention()` still writes to the dropped `post_id`/`timeline_element_id`/`quest_element_id`/`campaign_id` columns, throwing a SQL error on save.

- [ ] **Step 3: Refactor `createNewMention()`**

In `app/Services/EntityMappingService.php`, replace the `createNewMention()` method (lines 71-114) with:

```php
    protected function createNewMention(int $target): void
    {
        if ($this->model instanceof Post) {
            if ($this->model->entity_id == $target) {
                return;
            }
        } elseif ($this->model instanceof TimelineElement) {
            if ($this->model->timeline_id == $target) {
                return;
            }
        } elseif ($this->model instanceof QuestElement) {
            if ($this->model->quest_id == $target) {
                return;
            }
        } elseif (! $this->model instanceof Campaign) {
            // @phpstan-ignore-next-line
            if ($this->model->id == $target) {
                return;
            }
        }

        $mention = new EntityMention;
        $mention->mentionable()->associate($this->model);
        $mention->entity_id = $this->resolveEntityId();
        $mention->target_id = $target;
        $mention->save();
    }

    protected function resolveEntityId(): ?int
    {
        if ($this->model instanceof Campaign) {
            return null;
        } elseif ($this->model instanceof Post) {
            return $this->post()->entity_id;
        } elseif ($this->model instanceof TimelineElement) {
            return $this->model->timeline->entity->id;
        } elseif ($this->model instanceof QuestElement) {
            return $this->model->quest->entity->id;
        }

        // @phpstan-ignore-next-line
        return $this->model->id;
    }
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMappingServiceTest`
Expected: PASS

- [ ] **Step 5: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 6: Commit**

```bash
git add app/Services/EntityMappingService.php tests/Feature/Services/EntityMappingServiceTest.php
git commit -m "refactor: EntityMappingService::createNewMention uses mentionable() associate"
```

---

### Task 5: `BaseEntityMapper::foreignMentions()` — campaign-import mention mapping

**Files:**
- Modify: `app/Services/Campaign/Import/Mappers/BaseEntityMapper.php:402-430` (`foreignMentions()`)
- Test: `tests/Feature/Services/BaseEntityMapperForeignMentionsTest.php`

**Interfaces:**
- Consumes: `EntityMention` fillable (Task 2).
- Produces: `foreignMentions()` (unchanged signature/visibility) — now writes `mentionable_type`/`mentionable_id` instead of the dropped raw owner columns.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Facades\ImportIdMapper;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\Post;
use App\Services\Campaign\Import\Mappers\BaseEntityMapper;

test('foreignMentions() creates a Post-owned EntityMention using mentionable_type/mentionable_id', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $entity = Character::find(1)->entity;
    $target = Character::find(2)->entity;
    $post = Post::factory()->create(['entity_id' => $entity->id]);

    ImportIdMapper::putEntity(999, $target->id);
    ImportIdMapper::putPost(888, $post->id);

    $mapper = new class
    {
        use BaseEntityMapper;

        public Entity $entity;

        public Campaign $campaign;

        public array $data;

        public function run(): void
        {
            $this->foreignMentions();
        }
    };
    $mapper->entity = $entity;
    $mapper->campaign = Campaign::find(1);
    $mapper->data = [
        'entity' => [
            'mentions' => [
                ['target_id' => 999, 'post_id' => 888],
            ],
        ],
    ];

    (new ReflectionMethod($mapper, 'foreignMentions'))->setAccessible(true)->invoke($mapper);

    $mention = EntityMention::where('target_id', $target->id)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_type)->toBe(Post::class);
    expect($mention->mentionable_id)->toBe($post->id);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=BaseEntityMapperForeignMentionsTest`
Expected: FAIL — `foreignMentions()` still writes `$men->post_id = ...` etc, which are no longer real columns (Eloquent silently drops unknown attributes that aren't in `$fillable` when using mass-assignment, but here it's direct property assignment on a `new EntityMention` — since `post_id` is not `$fillable` and not a real column, `$men->save()` will insert a row with `mentionable_type`/`mentionable_id` left null instead, so the assertion on `mentionable_type` fails).

- [ ] **Step 3: Update `foreignMentions()`**

In `app/Services/Campaign/Import/Mappers/BaseEntityMapper.php`, replace lines 402-430 (`foreignMentions()`) with:

```php
    protected function foreignMentions(): self
    {
        if (empty($this->data['entity']['mentions'])) {
            return $this;
        }

        foreach ($this->data['entity']['mentions'] as $data) {
            if (! ImportIdMapper::hasEntity($data['target_id'])) {
                continue;
            }
            try {
                $men = new EntityMention;
                $men->target_id = ImportIdMapper::getEntity($data['target_id']);
                if (! empty($data['campaign_id'])) {
                    $men->mentionable_type = Campaign::class;
                    $men->mentionable_id = $this->campaign->id;
                } elseif (! empty($data['post_id'])) {
                    $men->mentionable_type = Post::class;
                    $men->mentionable_id = ImportIdMapper::getPost($data['post_id']);
                    $men->entity_id = $this->entity->id;
                } elseif (! empty($data['timeline_element_id'])) {
                    $men->mentionable_type = TimelineElement::class;
                    $men->mentionable_id = ImportIdMapper::getTimelineElement($data['timeline_element_id']);
                    $men->entity_id = $this->entity->id;
                } elseif (! empty($data['quest_element_id'])) {
                    $men->mentionable_type = QuestElement::class;
                    $men->mentionable_id = ImportIdMapper::getQuestElement($data['quest_element_id']);
                    $men->entity_id = $this->entity->id;
                } else {
                    $men->mentionable_type = Entity::class;
                    $men->mentionable_id = $this->entity->id;
                    $men->entity_id = $this->entity->id;
                }
                $men->save();
            } catch (Exception $e) {
                // Silence issues in parsing mentions
            }
        }
```

(Leave the rest of the method — the closing brace and any trailing lines after line 430 in the original — exactly as-is; only the body shown above changes.)

Add to the top of the file's `use` block: `use App\Models\Campaign;`, `use App\Models\QuestElement;`, `use App\Models\TimelineElement;` (alongside the existing `use App\Models\Post;` and `use App\Models\EntityMention;`).

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=BaseEntityMapperForeignMentionsTest`
Expected: PASS

- [ ] **Step 5: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 6: Commit**

```bash
git add app/Services/Campaign/Import/Mappers/BaseEntityMapper.php tests/Feature/Services/BaseEntityMapperForeignMentionsTest.php
git commit -m "refactor: BaseEntityMapper::foreignMentions writes mentionable_type/mentionable_id"
```

---

### Task 6: Regression coverage — rollup, backlinks, `filterValid`, Mentions tab

**Files:**
- Test: `tests/Feature/Models/EntityMentionRollupTest.php`
- Test: `tests/Feature/Controllers/MentionControllerTest.php`

**Interfaces:**
- Consumes: everything from Tasks 1-4 (no production code changes in this task — pure regression coverage for behavior the refactor must not break).

- [ ] **Step 1: Write the rollup/backlink/filterValid tests**

```php
<?php

use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\Quest;
use App\Models\QuestElement;

test('Entity::mentions() rolls up mentions from the entity\'s own entry and its posts', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    Post::factory()->create([
        'entity_id' => $author->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    // Two distinct mentions of the same target: one entity-owned, one post-owned,
    // both roll up under $author->mentions() via the shared entity_id column.
    expect($author->mentions()->count())->toBe(2);
    expect($author->mentions()->onEntity()->count())->toBe(1);
});

test('targetMentions() (backlinks) resolves regardless of owner type', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    Post::factory()->create([
        'entity_id' => $author->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    expect($target->targetMentions()->count())->toBe(2);
});

test('filterValid excludes a QuestElement-owned mention whose quest no longer resolves to an entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $quest = Quest::factory()->create(['campaign_id' => 1]);
    $element = QuestElement::factory()->create(['quest_id' => $quest->id]);

    $mention = EntityMention::create([
        'mentionable_type' => QuestElement::class,
        'mentionable_id' => $element->id,
        'entity_id' => $quest->entity->id,
        'target_id' => $target->id,
    ]);

    expect(EntityMention::filterValid()->whereKey($mention->id)->exists())->toBeTrue();

    $quest->entity->delete();

    expect(EntityMention::filterValid()->whereKey($mention->id)->exists())->toBeFalse();
});
```

- [ ] **Step 2: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=EntityMentionRollupTest`
Expected: PASS (this task adds coverage for behavior already correct after Tasks 1-4 — if it fails, it's a real regression in an earlier task, go back and fix there rather than adjusting these assertions).

- [ ] **Step 3: Write the Mentions-tab controller test**

```php
<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Timeline;
use App\Models\TimelineElement;

test('the entity Mentions tab renders a mention for each owner type', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $author = Character::factory()->create(['campaign_id' => 1])->entity;
    $campaign = Campaign::find(1);

    // Entity-owned
    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    // Post-owned
    Post::factory()->create(['entity_id' => $author->id, 'entry' => '[character:' . $target->id . ']']);

    // Campaign-owned
    $campaign->entry = '[character:' . $target->id . ']';
    $campaign->save();

    $response = $this->get(route('entities.mentions', ['campaign' => $campaign, 'entity' => $target]));

    $response->assertStatus(200);
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(3);
});
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MentionControllerTest`
Expected: PASS

- [ ] **Step 5: Run the full mentions-related test suite**

Run: `vendor/bin/sail artisan test --compact --filter=Mention`
Expected: All PASS (Tasks 1-6 combined).

- [ ] **Step 6: Commit**

```bash
git add tests/Feature/Models/EntityMentionRollupTest.php tests/Feature/Controllers/MentionControllerTest.php
git commit -m "test: add rollup, backlink, filterValid, and Mentions-tab regression coverage"
```
