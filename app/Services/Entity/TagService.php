<?php

namespace App\Services\Entity;

use App\Facades\EntityLogger;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class TagService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected bool $canCreate;

    protected bool $withNew = false;

    protected bool $withDetach = true;

    protected Model $model;

    protected bool $dirty = false;

    public function withNew(): self
    {
        $this->withNew = true;
        return $this;
    }

    public function model(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function add(array $ids): self
    {
        $this->withDetach = false;
        return $this->sync($ids);
    }

    public function isAllowed(): bool
    {
        if (!empty($this->canCreate)) {
            return $this->canCreate;
        }
        $campaign = $this->campaign ?? $this->entity->campaign;
        return $this->canCreate = $this->user->can('create', [
            $campaign->getEntityTypes()->firstWhere('id', config('entities.ids.tag')),
            $campaign
        ]);
    }


    public function create(mixed $name): Tag
    {
        $tag = new Tag([
            'name' => Purify::clean($name),
        ]);

        $tag->campaign_id = isset($this->campaign) ? $this->campaign->id : $this->entity->campaign_id;
        $tag->slug = Str::slug($tag->name, '');
        $tag->is_private = false;
        $tag->saveQuietly();
        $tag->createEntity();

        return $tag;
    }

    public function sync(array $ids): self
    {
        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        $this->dirty = false;
        /** @var MiscModel|Entity $model */
        $model = $this->entity ?? $this->model;

        /** @var Tag[]|Collection $tags */
        $tags = $model->tags()->with('entity')->has('entity')->get();
        foreach ($tags as $tag) {
            $existing[$tag->id] = $tag->name;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $tag = $this->fetch($id);
                if (empty($tag)) {
                    continue;
                }
                $new[] = $tag->id;
                $this->dirty = true;
                EntityLogger::dirty('tags', null);
            }
        }
        $model->tags()->attach($new);

        // Detach previously existing tags that were not requested
        if (empty($existing) || !$this->withDetach) {
            return $this;
        }
        $this->dirty = true;
        EntityLogger::dirty('tags', null);
        $model->tags()->detach(array_keys($existing));

        return $this;
    }

    /**
     * If the tags of the entity were changed, it gets flagged
     */
    public function isDirty(): bool
    {
        return $this->dirty;
    }

    protected function fetch(mixed $id): Tag|null
    {
        /** @var ?Tag $tag */
        $tag = Tag::select(['id', 'name'])->find($id);
        // Create the tag if the user has permission to do so
        if (empty($tag) && $this->withNew && $this->isAllowed()) {
            $tag = $this->create($id);
        }

        return $tag;
    }
}
