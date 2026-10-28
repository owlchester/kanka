<?php

namespace App\Mcp\Tools;

use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Gate;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('Returns a bounded entry dossier including visible articles, properties, status, and character details where applicable. Use continuation tools for more articles or properties.')]
#[IsReadOnly]
#[IsIdempotent]
class GetEntityTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context): ResponseFactory
    {
        $this->recordUsage();
        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'entity_id' => ['required', 'integer', 'min:1'],
            'entry_offset' => ['sometimes', 'integer', 'min:0', 'max:10000000'],
            'entry_limit' => ['sometimes', 'integer', 'min:1', 'max:20000'],
        ]);
        $user = $request->user();
        abort_unless($user instanceof User, 401);
        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);
        $entity = Entity::query()->with([
            'entityType', 'status',
            'child' => fn ($child) => $child->morphWith([
                Character::class => ['characterFamilies.family.entity', 'characterRaces.race.entity', 'characterTraits'],
            ]),
            'entityLocations.location.entity',
            'entityTags.tag.entity',
        ])->where('campaign_id', $campaign->id)->findOrFail($arguments['entity_id']);
        Gate::forUser($user)->authorize('view', $entity);
        $entry = $entity->entry ?? '';
        $entryLength = mb_strlen($entry);
        $entryOffset = (int) ($arguments['entry_offset'] ?? 0);
        $entryLimit = (int) ($arguments['entry_limit'] ?? 20000);
        $entryNextOffset = $entryOffset + min($entryLimit, max($entryLength - $entryOffset, 0));
        if ($entryNextOffset >= $entryLength) {
            $entryNextOffset = null;
        }

        $attributes = [];
        $attributesAvailable = Gate::forUser($user)->allows('viewAttributes', [$entity, $campaign]);
        if ($attributesAvailable) {
            $attributeRows = $entity->attributes()->orderBy('default_order')->orderBy('id')->limit(21)->get();
            $attributes = $attributeRows->slice(0, 20)->map(fn (Attribute $attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'type_id' => $attribute->type_id?->value,
                'value' => $attribute->isCheckbox() ? (bool) $attribute->value : $attribute->value,
                'is_hidden' => (bool) $attribute->is_hidden,
            ])->values()->all();
        }
        $postRows = $entity->posts()->orderBy('position')->orderBy('id')->limit(11)->get();
        $posts = $postRows->slice(0, 10)->map(fn ($post) => [
            'id' => $post->id,
            'name' => $post->name,
            'entry' => mb_substr((string) $post->entry, 0, 4000),
            'entry_length' => mb_strlen((string) $post->entry),
            'entry_truncated' => mb_strlen((string) $post->entry) > 4000,
            'updated_at' => $post->updated_at?->toIso8601String(),
        ])->values()->all();
        $character = $entity->child instanceof Character ? $entity->child : null;
        $character?->setRelation('entity', $entity);
        $visibleEntity = fn ($linkedEntity) => $linkedEntity && Gate::forUser($user)->allows('view', $linkedEntity);
        $locations = $entity->entityLocations->filter(fn ($link) => $visibleEntity($link->location?->entity))
            ->map(fn ($link) => ['id' => $link->location->entity->id, 'name' => $link->location->entity->name, 'url' => $link->location->entity->url()])->values()->all();
        $tags = $entity->entityTags->filter(fn ($link) => $visibleEntity($link->tag?->entity))
            ->map(fn ($link) => ['id' => $link->tag->entity->id, 'name' => $link->tag->entity->name])->values()->all();
        $families = $character?->characterFamilies->filter(fn ($link) => $link->family && $visibleEntity($link->family->entity))
            ->map(fn ($link) => ['id' => $link->family->entity->id, 'name' => $link->family->entity->name, 'url' => $link->family->entity->url()])->values()->all() ?? [];
        $races = $character ? $character->characterRaces->filter(fn ($link) => $link->race && $visibleEntity($link->race->entity))
            ->map(fn ($link) => ['id' => $link->race->entity->id, 'name' => $link->race->entity->name, 'url' => $link->race->entity->url()])->values()->all() : [];
        $traits = ['appearance' => [], 'personality' => []];
        if ($character instanceof Character) {
            $canViewPrivateTraits = $user->can('admin', $campaign);
            $canViewPersonality = Gate::forUser($user)->allows('personality', $character);
            foreach ($character->characterTraits->sortBy([['default_order', 'asc'], ['id', 'asc']]) as $trait) {
                if ($trait->is_private && ! $canViewPrivateTraits) {
                    continue;
                }
                if ($trait->section_id === CharacterTrait::SECTION_PERSONALITY && ! $canViewPersonality) {
                    continue;
                }
                $section = $trait->section_id === CharacterTrait::SECTION_APPEARANCE ? 'appearance' : 'personality';
                $traits[$section][] = [
                    'id' => $trait->id,
                    'name' => $trait->name,
                    'entry' => $trait->entry,
                ];
            }
        }

        return Response::structured([
            'id' => $entity->id,
            'campaign_id' => $campaign->id,
            'name' => $entity->name,
            'module' => ['id' => $entity->entityType->id, 'code' => $entity->entityType->code, 'name' => $entity->entityType->name()],
            'type' => $entity->type,
            'status' => $entity->status ? ['id' => $entity->status->id, 'key' => $entity->status->key] : null,
            'locations' => $locations,
            'tags' => $tags,
            'character' => $character instanceof Character ? [
                'title' => $character->title,
                'age' => $character->age,
                'sex' => $character->sex,
                'pronouns' => $character->pronouns,
                'families' => $families,
                'races' => $races,
                'traits' => $traits,
            ] : null,
            'properties' => ['items' => $attributes, 'has_more' => $attributesAvailable && $attributeRows->count() > 20],
            'articles' => ['items' => $posts, 'has_more' => $postRows->count() > 10],
            'description' => mb_substr($entry, $entryOffset, $entryLimit),
            'description_length' => $entryLength,
            'entry_offset' => $entryOffset,
            'entry_next_offset' => $entryNextOffset,
            'updated_at' => $entity->updated_at?->toIso8601String(),
            'url' => $entity->url(),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'entity_id' => $schema->integer()->description('Kanka entity ID, not the ID of its module-specific child record.')->required(),
            'entry_offset' => $schema->integer()->description('Character offset to continue reading a long entry.'),
            'entry_limit' => $schema->integer()->description('Maximum entry characters to return (at most 20000).'),
        ];
    }
}
