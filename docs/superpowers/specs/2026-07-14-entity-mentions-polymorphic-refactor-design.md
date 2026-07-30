# Entity Mentions Polymorphic Refactor Design

## Goal

Replace `entity_mentions`'s five nullable owner columns (`entity_id`, `post_id`, `timeline_element_id`, `quest_element_id`, `campaign_id`) with a single Laravel polymorphic pair (`mentionable_type`, `mentionable_id`), so adding a new mentionable model (starting with `MapMarker`, see the follow-up Tiptap/maps spec) requires no schema change. Preserve every existing behavior: the "Mentions" tab, backlinks (`targetMentions()`), and the entity-level rollup that shows a Post/Timeline/Quest mention under its parent Entity.

## Out of Scope

- `ImageMention` / `image_mentions` table (`Image::mentions()`) — a separate system, untouched.
- Wiring `MapMarker` in as a new mentionable type, or any Tiptap/maps work — that's the next spec, built on top of this one.
- `target_id` (the mentioned entity) — already a plain FK to `entities`, not part of this refactor.
- Changing how mentions are parsed out of HTML (`SaveService`) or rendered back (`MentionsService`) — bracket-syntax `[type:id]` parsing is unaffected; this refactor is purely about how `EntityMention` rows record *who owns* the mention.

## Background

`entity_id` is currently dual-purpose:

1. **Direct owner** — when an `Entity`'s own entry field contains a mention, `entity_id` = that entity's id, and `post_id`/`timeline_element_id`/`quest_element_id`/`campaign_id` are all null.
2. **Denormalized rollup** — when a `Post`/`TimelineElement`/`QuestElement` contains a mention, the specific owner column (`post_id` etc.) is set *and* `entity_id` is also set, to that owner's parent entity. This is what lets `Entity::mentions()` (a single `hasMany` on `entity_id`) return "everything mentioned anywhere under this entity" for the Mentions tab, and what `EntityMention::scopeOnEntity()` filters *out* to isolate "mentioned directly in the entity's own entry."

A naive single-morph swap (`mentionable_type`/`mentionable_id` only) would break the rollup — `Entity::mentions()` would need to become a cross-table union query. Instead, this design keeps `entity_id` as a dedicated rollup column and only collapses the *owner-discriminator* columns into the morph pair. `campaign_id` disappears entirely — a campaign-owned mention has no parent entity, so it just becomes `mentionable_type = Campaign::class` with `entity_id` left null.

There is no existing test coverage for `EntityMention`, `EntityMappingService`, or `HasMentions` (`grep -rln "EntityMention|entity_mentions|targetMentions|createNewMention" tests/` returns nothing) and no precedent in this codebase for chunked/batched data migrations. The backfill here is a same-table column consolidation (not a cross-table copy), so a plain set-based `UPDATE` per legacy column is used rather than inventing a chunking pattern for a single-use migration.

## Architecture

### Schema

One migration:

- Add `mentionable_type` (string, nullable during backfill), `mentionable_id` (unsignedBigInteger, nullable during backfill).
- Backfill, one `UPDATE` per legacy owner column (order doesn't matter, columns are mutually exclusive):
  ```sql
  UPDATE entity_mentions SET mentionable_type = 'App\Models\Entity', mentionable_id = entity_id WHERE entity_id IS NOT NULL AND post_id IS NULL AND timeline_element_id IS NULL AND quest_element_id IS NULL;
  UPDATE entity_mentions SET mentionable_type = 'App\Models\Post', mentionable_id = post_id WHERE post_id IS NOT NULL;
  UPDATE entity_mentions SET mentionable_type = 'App\Models\TimelineElement', mentionable_id = timeline_element_id WHERE timeline_element_id IS NOT NULL;
  UPDATE entity_mentions SET mentionable_type = 'App\Models\QuestElement', mentionable_id = quest_element_id WHERE quest_element_id IS NOT NULL;
  UPDATE entity_mentions SET mentionable_type = 'App\Models\Campaign', mentionable_id = campaign_id WHERE campaign_id IS NOT NULL;
  ```
  (The first statement's extra `AND ... IS NULL` guards excludes rows where `entity_id` is only the rollup value for a Post/Timeline/Quest owner — those are handled by their own statement.)
- Add index on `(mentionable_type, mentionable_id)`.
- Drop `post_id`, `timeline_element_id`, `quest_element_id`, `campaign_id` and their FKs. Keep `entity_id`, but drop its FK-cascade-on-delete (a stale rollup value must no longer force-delete the mention row — validity is now enforced live by `scopeFilterValid()`, not by DB cascade) and make it purely advisory/nullable.
- `down()` reverses: re-add the four columns, re-populate from `mentionable_type`/`mentionable_id`, drop the morph columns.

### `EntityMention` model

- Add `mentionable(): MorphTo`.
- `fillable`: `mentionable_type`, `mentionable_id`, `entity_id`, `target_id`.
- Backward-compatible accessors so `mention-link.blade.php` and `Renderers/Layouts/Mention/Mention.php` need no changes:
  - `isEntity()`/`isPost()`/`isTimelineElement()`/`isQuestElement()`/`isCampaign()` — check `mentionable_type === X::class` instead of `!empty($column)`.
  - `post()`, `timelineElement()`, `questElement()`, `campaign()` — each a `belongsTo(X::class, 'mentionable_id')`, only meaningful (and only ever accessed) when the matching `isX()` is true, exactly like today.
  - `entity()` stays a real `belongsTo(Entity::class, 'entity_id')` — unchanged, still the rollup.
- Scopes:
  - `scopeOnEntity()` / `scopeOnPost()` / `scopeOnTimelineElement()` / `scopeOnQuestElement()` / `scopeOnCampaign()` → `where('mentionable_type', X::class)`.
  - `scopeFilterValid()` → replace the current `has()` OR-chain with `whereHasMorph('mentionable', [Entity::class, Post::class, TimelineElement::class, QuestElement::class, Campaign::class], fn ($q, $type) => match($type) { Post::class => $q->has('entity'), TimelineElement::class => $q->has('timeline.entity'), QuestElement::class => $q->has('quest.entity'), default => null })` — same intent (drop rows whose owner's parent chain is broken), expressed with Laravel's morph-aware scope instead of the current per-column `has()` calls.
  - `scopeDatagridElements()` — unchanged, still joins `entities` on `entity_id`.

### Per-model `mentions()` relations

- `HasMentions` trait (`Entity`): `mentions()` stays `hasMany(EntityMention::class, 'entity_id')` (the rollup — this is *why* `entity_id` survives). `targetMentions()` stays `hasMany(EntityMention::class, 'target_id')`. Unaffected.
- `Post::mentions()`, `TimelineElement::mentions()`, `QuestElement::mentions()`: become `morphMany(EntityMention::class, 'mentionable')` instead of a hand-rolled `hasMany` on a dedicated column.
- `CampaignRelations::mentions()` (used by `Campaign`): same, becomes `morphMany(EntityMention::class, 'mentionable')`.

### `EntityMappingService`

- `createNewMention(int $target)`: collapse the current 5-branch `if/elseif` into:
  ```php
  $mention = new EntityMention();
  $mention->mentionable()->associate($this->model);
  $mention->entity_id = $this->resolveEntityId();
  $mention->target_id = $target;
  $mention->save();
  ```
  New private `resolveEntityId(): ?int` — `Entity` → `$this->model->id`; `Post`/`TimelineElement`/`QuestElement` → their existing parent-entity lookup (same logic as today, just extracted); `Campaign` → `null`.
- `entry()`: unchanged — it already reads `$this->model->mentions` generically via the relation, so it doesn't care whether that relation is a plain `hasMany` or a `morphMany`.
- `campaignID()`: unchanged, doesn't touch the owner columns.

### Call sites (no change required, verified against research)

- `Http/Controllers/Entity/MentionController.php`, `Api/v1/EntityMentionApiController.php`, `Entities/Apis/DocumentController.php`, `Services/Entity/Connections/MapService.php` — all call `mentions()`/`targetMentions()` by relation name only; internal implementation swap is invisible to them.
- `mention-link.blade.php`, `Renderers/Layouts/Mention/Mention.php` — covered by the backward-compatible accessors above.

## Testing

No existing coverage, so this spec adds it from scratch (Pest feature tests):

- `EntityMappingService::createNewMention()` for each owner type (Entity, Post, TimelineElement, QuestElement, Campaign) — assert `mentionable_type`/`mentionable_id` set correctly, `entity_id` rollup correct (including `null` for Campaign).
- `Entity::mentions()` returns mentions from the entity's own entry *and* from its posts/timeline/quest elements (rollup behavior).
- `EntityMention::scopeOnEntity()` excludes rollup-only rows (Post/Timeline/Quest-owned mentions whose `entity_id` happens to match).
- `scopeFilterValid()` excludes a mention whose owner's parent chain is broken (e.g. a `QuestElement` mention where the quest was deleted without cascading).
- `targetMentions()` (backlinks) still resolves regardless of owner type.
- Mentions tab datagrid (`MentionController`) renders correctly for a mention of each owner type — covers the accessor backward-compatibility.
- Migration: a small dataset seeded with the legacy columns populated, migration run, assert `mentionable_type`/`mentionable_id` correctly backfilled per owner type and `down()` correctly reverses it.
