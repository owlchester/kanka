<?php

namespace App\Services\Entity;

use App\Facades\UserCache;
use App\Models\Ability;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class NewService
{
    use CampaignAware;
    use PurifiableTrait;
    use UserAware;

    protected array $tags;

    protected array $available;

    protected MiscModel $model;

    public function model(MiscModel $miscModel): self
    {
        $this->model = $miscModel;
        return $this;
    }

    /**
     * Get a list of available entity types the user can create
     */
    public function available(): array
    {
        if (isset($this->available)) {
            return $this->available;
        }

        if (!auth()->check()) {
            return $this->available = [];
        }

        $newTypes = $this->preset();
        $entities = [];
        foreach ($newTypes as $type => $class) {
            if ($this->campaign->enabled(Str::plural($type)) && auth()->user()->can('create', $class)) {
                $entities[$type] = $class;
            }
        }

        return $this->available = $entities;
    }

    public function create(string $name): MiscModel
    {
        $name = Str::replace(['&lt;', '&gt;'], ['<', '>'], $name);
        $this->model->name = $this->purify(trim(strip_tags($name)));
        $this->model->is_private = $this->private();
        $this->model->campaign_id = $this->campaign->id;

        $this->model->saveQuietly();
        $this->model->createEntity();
        if (!$this->model->entity->isTag()) {
            $allTags = $this->autoTags();
            $this->model->entity->tags()->attach($allTags);
        }

        return $this->model;
    }

    protected function private(): bool
    {
        return (bool) (UserCache::user($this->user)->admin() && $this->campaign->entity_visibility);
    }


    public function autoTags(): array
    {
        if (isset($this->tags)) {
            return $this->tags;
        }
        $this->tags = [];
        $tags = Tag::autoApplied()->has('entity')->get();
        foreach ($tags as $tag) {
            $this->tags[] = $tag->id;
        }

        return $this->tags;
    }

    protected function preset(): array
    {
        return [
            'character' => Character::class,
            'location' => Location::class,
            'creature' => Creature::class,
            'race' => Race::class,
            'item' => Item::class,
            'note' => Note::class,
            'family' => Family::class,
            'organisation' => Organisation::class,
            'event' => Event::class,
            'journal' => Journal::class,
            'ability' => Ability::class,
            'quest' => Quest::class,
            'tag' => Tag::class,
        ];
    }
}
