<?php

namespace App\Services\Entity;

use App\Models\Tag;
use App\Traits\EntityAware;
use App\User;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class TagService
{
    use EntityAware;

    protected array $tagIds = [];

    protected bool $canCreate = false;

    public function user(User $user): self
    {
        $this->canCreate = $user->can('create', Tag::class);
        return $this;
    }

    public function isAllowed(): bool
    {
        return $this->canCreate;
    }

    public function fetch(mixed $id, int $campaignID): Tag|null
    {
        /** @var Tag|null $tag */
        $tag = Tag::find($id);
        // Create the tag if the user has permission to do so
        if (empty($tag) && $this->canCreate) {
            $tag = $this->create($id, $campaignID);
        }

        return $tag;
    }

    public function create(mixed $name, int $campaignID): Tag
    {
        $tag = new Tag([
            'name' => Purify::clean($name),
        ]);
        $tag->campaign_id = $campaignID;
        $tag->slug = Str::slug($tag->name, '');
        $tag->is_private = false;
        $tag->saveQuietly();
        $tag->createEntity();
        return $tag;
    }
}
