<?php

namespace App\Services\Entity;

use App\Facades\CampaignLocalization;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Tag;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class NewService
{
    use CampaignAware;
    use UserAware;
    use PurifiableTrait;

    protected array $tags;

    protected MiscModel $model;

    public function model(MiscModel $miscModel): self
    {
        $this->model = $miscModel;
        return $this;
    }

    public function create(string $name): MiscModel
    {
        $name = Str::replace(['&lt;', '&gt;'], ['<', '>'], $name);
        $this->model->name = $this->purify(trim(strip_tags($name)));
        $this->model->slug = Str::slug($this->model->name, '');
        $this->model->is_private = $this->private();
        $this->model->campaign_id = $this->campaign->id;

        // If the modal is a tree, it needs to be placed in its own bounds
        if (method_exists($this->model, 'makeRoot')) {
            // @phpstan-ignore-next-line
            $this->model->recalculateTreeBounds();
        }

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
        if ($this->user->isAdmin() && $this->campaign->entity_visibility) {
            return true;
        }
        return false;
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
}
