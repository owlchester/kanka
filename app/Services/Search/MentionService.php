<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Post;
use App\Services\Entity\NewService;
use App\Services\EntityTypeService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class MentionService
{
    use CampaignAware;
    use EntityAware;
    use RequestAware;
    use UserAware;

    protected string $term;

    protected string $strippedTerm;

    protected array $data;

    protected int $limit = 15;

    public function __construct(
        protected EntityTypeService $entityTypeService,
        protected NewService $newService) {}

    public function search(): array
    {
        return $this
            ->prepare()
            ->entities()
            ->posts()
            ->attributes()
            ->new()
            ->data();
    }

    public function load(): array
    {
        $results = [];

        if ($this->request->filled('entities')) {
            $entities = Entity::with(['image', 'entityType', 'aliases'])->whereIn('id', $this->request->get('entities'))->get();
            foreach ($entities as $entity) {
                if ($entity->entityType->isStandard() && ! $entity->child) {
                    continue;
                }
                $results[] = $this->formatEntity($entity);
            }
        }

        if ($this->request->filled('posts')) {
            $posts = Post::has('entity')->whereIn('id', $this->request->get('posts'))->get();
            foreach ($posts as $post) {
                $results[] = [
                    'type' => 'post',
                    'id' => $post->id,
                    'name' => $post->name,
                    'inject' => "[post:{$post->id}]",
                ];
            }
        }

        return $results;
    }

    protected function prepare(): self
    {
        if ($this->request->has('entity')) {
            $entity = Entity::find(['id' => $this->request->get('entity')])->first();
            if ($entity) {
                $this->entity($entity);
            }
        }

        $this->term = mb_trim(Str::replace('_', ' ', $this->request->get('q')));
        $this->strippedTerm = mb_ltrim($this->term, '=');

        return $this;
    }

    protected function entities(): self
    {
        // Figure out what kind of entities we want.
        $availableEntityTypes = $this->entityTypeService
            ->campaign($this->campaign)
            ->available()
            ->pluck('id')
            ->toArray();

        $query = Entity::inTypes($availableEntityTypes)
            ->where('entities.campaign_id', $this->campaign->id)
            ->whereNull('archived_at')
            ->where(function ($sub) {
                if (Str::startsWith($this->term, '=')) {
                    $sub->where('entities.name', $this->strippedTerm)
                        ->orWhereHas('aliases', fn ($alias) => $alias->where('name', $this->strippedTerm));
                } else {
                    $sub->where('entities.name', 'like', '%' . $this->term . '%')
                        ->orWhereHas('aliases', fn ($alias) => $alias->where('name', 'like', '%' . $this->term . '%'));
                }
            })
            ->orderBy('entities.name');
        $with = ['image', 'entityType', 'aliases'];

        $query
            ->with($with)
            ->limit($this->limit);

        $this->data['entities'] = [];
        /** @var Entity $entity */
        foreach ($query->get() as $entity) {
            $alias = $entity->aliases->first(function ($alias): bool {
                if (Str::startsWith($this->term, '=')) {
                    return $alias->name === $this->strippedTerm;
                }

                return str_contains(mb_strtolower($alias->name), mb_strtolower($this->term));
            });
            $entity->setAttribute('alias_id', $alias?->id);
            $entity->setAttribute('alias_name', $alias?->name);
            $this->addEntity($entity);
        }

        return $this;
    }

    protected function addEntity(Entity $entity): void
    {
        // Force having a child for "ghost" entities.
        if ($entity->entityType->isStandard() && ! $entity->child) {
            return;
        }

        $this->data['entities'][] = $this->formatEntity($entity);
    }

    protected function formatEntity(Entity $entity): array
    {
        $mention = '[' . $entity->entityType->code . ':' . $entity->id . ']';
        // @phpstan-ignore-next-line
        if ($entity->alias_id) {
            $mention = '[' . $entity->entityType->code . ':' . $entity->id . '|alias:' . $entity->alias_id . ']';
        }

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => $entity->entityType->name(),
            'is_private' => $entity->is_private,
            'image' => Avatar::entity($entity)->fallback()->size(32)->thumbnail(),
            'image_alt' => $entity->image?->description ?: $entity->name,
            'url' => $entity->url(),
            'preview' => route('entities.preview', [$this->campaign, $entity]),
            'mention' => $mention,
            'alias_name' => $entity->alias_name ?? null,
            'alias_id' => $entity->alias_id ?? null,
            'aliases' => $entity->aliases->map(fn ($alias) => [
                'id' => $alias->id,
                'name' => $alias->name,
            ])->toArray(),
        ];
    }

    protected function attributes(): self
    {
        if (! isset($this->entity)) {
            return $this;
        }

        $query = $this->entity->entityAttributes();
        if (Str::startsWith($this->term, '=')) {
            $query->where('attributes.name', $this->strippedTerm);
        } else {
            $query->where('attributes.name', 'like', '%' . $this->term . '%');
        }
        $attributes = $query->limit($this->limit)->get();
        if ($attributes->isEmpty()) {
            return $this;
        }

        $this->data['attributes'] = [];
        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }

        return $this;
    }

    protected function addAttribute(Attribute $attribute): void
    {
        $this->data['attributes'][] = [
            'id' => $attribute->id,
            'type' => 'post',
            'name' => $attribute->name,
            'value' => $attribute->value,
            'inject' => "{attribute:{$attribute->id}}",
        ];
    }

    protected function posts(): self
    {
        if (! isset($this->entity)) {
            return $this;
        }

        $query = $this->entity->posts();
        if (Str::startsWith($this->term, '=')) {
            $query->where('posts.name', $this->strippedTerm);
        } else {
            $query->where('posts.name', 'like', '%' . $this->term . '%');
        }
        $posts = $query->limit($this->limit)->get();
        if ($posts->isEmpty()) {
            return $this;
        }

        $this->data['posts'] = [];
        foreach ($posts as $post) {
            $this->addPost($post);
        }

        return $this;
    }

    protected function addPost(Post $post): void
    {
        $this->data['posts'][] = [
            'type' => 'post',
            'id' => $post->id,
            'name' => $post->name,
            'inject' => "[post:{$post->id}]",
        ];
    }

    protected function new(): self
    {
        $options = [];
        if (! isset($this->user)) {
            return $this;
        }
        $available = $this->newService
            ->campaign($this->campaign)
            ->user($this->user)
            ->available();

        // Re-order alphabetically and in groups of custom vs default

        $available = $available->sortBy(fn (EntityType $a) => $a->isStandard() . '.' . $a->name());
        $this->data['new'] = [];

        foreach ($available as $entityType) {
            $this->data['new'][] = [
                'inject' => '[new:' . $entityType->code . '|' . $this->term . ']',
                'type' => __('crud.titles.new', ['module' => $entityType->name()]),
                'name' => $this->term,
            ];
        }

        return $this;
    }

    protected function data(): array
    {
        return $this->data;
    }
}
